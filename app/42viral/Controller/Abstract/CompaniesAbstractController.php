<?php
/**
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');
App::uses('HttpSocketOauth', 'Lib');
App::uses('Address', 'Model');

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
    public $uses = array('Company', 'Address', 'YelpApi', 'YahooApi');


    public $components = array('ProfileProgress');


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
            $yelpResults = $this->__profileDoYelp($company);
            
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
        //$generatedCompanyId = String::uuid();

        //$companyData['Company']['id'] = $generatedCompanyId;
        $companyData['Company']['owner_user_id'] = $this->Session->read('Auth.User.id');

        if(isset($this->data['Company']['name'])) {
            $companyData['Company']['name_normalized'] = Inflector::slug(strtolower($this->data['Company']['name']));
        }

        if($this->Company->save($companyData)) {
            $companyAddress = $companyData['Address'];
            $companyAddress['model'] = 'Company';
            $companyAddress['model_id'] = $this->Company->id;

            $this->Address->save($companyAddress);

            $this->Session->setFlash(__('The company details were saved successfully'), 'success');

            $userId = $this->Session->read('Auth.User.id');
            $overallProgress = $this->ProfileProgress->fetchOverallProfileProgress($userId);
            if($overallProgress['_all'] < 100) {
                $this->redirect('/members/complete_profile');
            } else {
                $this->redirect('/companies/index');
            }


        } else {
            $this->Session->setFlash(__('There was a problem saving the company details'), 'error');
            $this->redirect('/companies/create');
        }
    }

    /**
     * Action to delete a company record
     *
     * @access public
     * @param string $companyId
     */
    public function delete($companyId)
    {
        if($this->Company->delete($companyId, true /* cascade */)) {
            $this->Session->setFlash(__('The company was deleted successfully'), 'success');
        } else {
            $this->Session->setFlash(__('There was a problem deleting the company'), 'error');
        }


        $this->redirect('/companies/index');
    }


    /**
     * Helper function to fetch Yahoo Local Search listings for the given company
     *
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access private
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
                'query' => '*',
                'listing_id' => $company['Company']['yahoo_listing_id']
            );
        } else {

            if(isset($company['Address']) && !empty($company['Address'])) {
                $requestParams = array(
                    'query' => $company['Company']['name'],
                    'location' => $company['Address'][0]['_us_full_address']
                );
            } else {
                $requestParams = array(
                    'query' => $company['Company']['name']
                );
            }

        }

        return $this->YahooApi->find('all', array(
            'conditions' => $requestParams
        ));
    }


    /**
     * Helper function to fetch Yelp Business listings and review data for the given company
     *
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access private
     * @param Company company object to use for pulling listing data from Yahoo
     * @return mixed
     */
    private function __profileDoYelp($company)
    {
        $queryTerms = array(
            'limit' => 5,
            'term' => $company['Company']['name']
        );

        if(isset($company['Address']) && !empty($company['Address'])) {
            $queryTerms['location'] = $company['Address'][0]['_us_full_address'];
        }

        $results = $this->YelpApi->find('all', array(
            'conditions' => $queryTerms
        ));

        return $results;
    }
}
