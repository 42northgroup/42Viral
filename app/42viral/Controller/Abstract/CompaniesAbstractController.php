<?php

App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * Abstract class to represent a generic company object which can be customized by subclassing from this class
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
abstract class CompaniesAbstractController extends AppController
{

    /**
     * Use these models
     * @var array
     */
    public $uses = array('Company', 'Address');


    /**
     * Default index action method to list all companies
     *
     * @access public
     */
    public function index()
    {
        $companies = $this->Company->fetchAllCompaniesWith(array('Address'));
        $this->set('companies', $companies);
    }


    /**
     * Action to view a single company profile given its name
     *
     * @access public
     * @param string $companyName
     */
    public function view($companyName)
    {
        //$company = $this->Company->fetchCompanyByNameWith($companyName);
        $company = $this->Company->fetchCompanyByNameWith($companyName, array('Address'));

        $yahooResults = null;
        $yelpResults = null;
        $googleResults = null;

        if(!empty($company)) {
            $yahooResults = $this->__profileDoYahoo($company);
            $yelpResults = array();
            $googleResults = array();
        }

        $webResults = array(
            'yahoo' => $yahooResults,
            'yelp' => $yelpResults,
            'google' => $googleResults
        );

        $this->set('web_results', $webResults);
        $this->set('company', $company);
    }




    /**
     * Action to view all companies of the currently logged in user
     *
     * @access public
     */
    public function mine()
    {
        $userId = null;
        $company = null;

        if($this->Session->check('Auth.User.id')) {
            $userId = $this->Session->read('Auth.User.id');
            $companies = $this->Company->fetchUserCompaniesWith($userId, array('Address'));
        }

        $this->set('companies', $companies);
    }


    /**
     * Action method to display a form for creating a new company profile
     *
     * @access public
     */
    public function create() {}


    /**
     * Action to save a company profile
     *
     * @access public
     */
    public function save()
    {

        $companyData = $this->data;
        $generatedCompanyId = String::uuid();

        $companyData['Company']['id'] = $generatedCompanyId;
        $companyData['Company']['owner_person_id'] = $this->Session->read('Auth.User.id');

        $companyAddress = $companyData['Address'];
        $companyAddress['model'] = 'Company';
        $companyAddress['model_id'] = $generatedCompanyId;

        if(isset($this->data['Company']['name'])) {
            $companyData['Company']['name_normalized'] = Inflector::underscore($this->data['Company']['name']);
        }

        if($this->Company->save($companyData)) {
            $this->Address->save($companyAddress);

            $this->Session->setFlash(__('The company details were saved successfully'), 'success');
            $this->redirect('/companies/index');
        } else {
            $this->Session->setFlash(__('There was a problem saving the company details'), 'error');
            $this->redirect('/companies/create');
        }
    }


    /**
     * Helper function to fetch Yahoo Local Search listings for the given company
     *
     * @access public
     * @param Company company object to use for pulling listing data from Yahoo
     * @return mixed
     */
    private function __profileDoYahoo($company)
    {
        if(
            isset($company['Company']['yahoo_listing_id']) &&
            !empty($company['Company']['yahoo_listing_id'])
        ) {
            $requestParams = array(
                'appid' => APP_ID_YAHOO_LOCAL_SEARCH,
                'output' => 'php',
                'query' => '*',
                'listing_id' => $company['Company']['yahoo_listing_id']
            );
        } else {

            if(isset($company['Address']) && !empty($company['Address'])) {
                $requestParams = array(
                    'appid' => APP_ID_YAHOO_LOCAL_SEARCH,
                    'output' => 'php',
                    'query' => $company['Company']['name'],
                    'location' => $company['Address'][0]['_us_full_address']
                );
            } else {
                $requestParams = array(
                    'appid' => APP_ID_YAHOO_LOCAL_SEARCH,
                    'output' => 'php',
                    'query' => $company['Company']['name']
                );
            }

        }


        $requestObject = array(
            'requestUrl' => 'http://local.yahooapis.com/LocalSearchService/V3/localSearch',
            'params' => $requestParams
        );

        $HttpSocket = new HttpSocket();

        $yahooResponse = $HttpSocket->get(
            $requestObject['requestUrl'], $requestObject['params']
        );

        $resultsObject = unserialize($yahooResponse->body);

        return $resultsObject['ResultSet'];
    }
}
