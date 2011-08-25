<?php

App::uses('CompaniesAbstractController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * @package app
 * @subpackage app.core
 */
class CompaniesController extends CompaniesAbstractController
{

    /**
     *
     * @var type
     */
    public $uses = array('Company');


    /**
     *
     *
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access public
     */
    public function index()
    {
        $companies = $this->Company->fetchAllCompanies();
        $this->set('companies', $companies);
    }


    /**
     *
     *
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access public
     */
    public function view($companyName)
    {
        $company = $this->Company->fetchCompanyByName($companyName);
        $this->set('company', $company);
    }


    /**
     *
     *
     * @return void
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access public
     */
    public function profile()
    {
        //$this->Session->read('Auth.User.User.id');

        $userId = null;

        if($this->Session->check('Auth.User.User.id')) {
            $userId = $this->Session->read('Auth.User.User.id');
        }

        if(!is_null($userId)) {
            $company = $this->Company->fetchUserCompany($userId);
        }

        $yahooResults = $this->__profileDoYahoo($company);
        $yelpResults = array();
        $googleResults = array();

        $results = array(
            'yahoo' => $yahooResults,
            'yelp' => $yelpResults,
            'google' => $googleResults
        );

        $this->set('results', $results);
    }


    /**
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access public
     * @return type
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
                'listing_id' => '40830988'
            );
        } else {
            $requestParams = array(
                'appid' => APP_ID_YAHOO_LOCAL_SEARCH,
                'output' => 'php',
                'query' => $company['Company']['name'],
                'street' => $company['Company']['addr_line1'] .' '. $company['Company']['addr_line2'],
                'city' => $company['Company']['addr_city'],
                'state' => $company['Company']['addr_state'],
                'zip' => $company['Company']['addr_zip'],
            );
        }

        //pr($requestParams);

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


    /**
     *
     *
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access public
     */
    public function profile_create()
    {

    }


    /**
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access public
     */
    public function profile_save()
    {

        $tempData = $this->data;
        $tempData['Company']['owner_person_id'] = $this->Session->read('Auth.User.User.id');

        if($this->Company->save($tempData)) {
            $this->Session->setFlash(__('The company details were saved successfully'), 'success');
            $this->redirect('/companies/profile');
        } else {
            $this->Session->setFlash(__('There was a problem saving the company details'), 'error');
            $this->redirect('/companies/profile_create');
        }
    }

}
