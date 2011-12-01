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
App::uses('Member', 'Lib');

/**
 * Abstract class to represent a generic company object which can be customized by subclassing from this class
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.org>
 */
 class ProfileCompaniesController extends AppController
{

    /**
     * @var array
     * @access public
     */
    public $uses = array('Address', 'ProfileCompany', 'Person', 'YahooApi', 'YelpApi');

    /**
     * @var array
     * @access public
     */
    public $components = array('ProfileProgress');

    /**
     * @return void
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->auth(array('index', 'view'));
    }
    
    /**
     * Default index action method to list all companies
     * @param string username
     * @access public
     */
    public function index($username = null)
    {
        
        if(!is_null($username)){
            //Show all the accounts for a particular user
            $person = $this->Person->fetchPersonWith($username, array('ProfileCompany'=> array('Address')));
            $companies = $person['ProfileCompany'];
            //Set the user profile array
            $this->set('userProfile', $person);

        }else{
            
            //Show all accounts
            $companies = $this->ProfileCompany->fetchAllCompaniesWith(array('Address'));
            //Make the comopany array look like the person array            
            $companies = Set::extract('/ProfileCompany/.',$companies);
            
        }
        
        $this->set('companies', $companies);
        
        if(is_null($username)){
            $this->set('title_for_layout', __('Profile Company Index'));
        }else{
            $this->set('title_for_layout', 
                    sprintf(__("%s's Companies"), Member::name($person['Person'])),
                    Member::name($person['Person']) . "'s " . __('Companies'));
        }
 
    }

    /**
     * Action to view a single company profile given its name
     *
     * @access public
     * @param string $companyName
     */
    public function view($slug)
    {
        $mine = false;
        
        //Holds the connection "status" of a various service queries
        $company = $this->ProfileCompany->fetchCompanyWith($slug, array('Address'));

        //For reviews and the like we will build 2 arrays. $webResults which will hold the results of all of the 
        //services query and $connect which hold the connection status of all of the services.
        $webResults = array();
        $connect = array();
        
        //Each of these represent a single service and a single element in the $webResults array
        $yahooResults = null;
        $yelpResults = null;
        $googleResults = null;

        //If we have a company, get busy
        if(!empty($company)) {
            App::uses('ConnectionManager', 'Model');
            
            //Try Yahoo! 
            
            //Do we have a configuration defined for Yahoo!?
            try{
                $connect['yahoo'] = ConnectionManager::getDataSource('yahoo');
                
                //Yes, Yahoo! has a configuration defined.
                //Can we get any results from Yahoo!?
                try{
                    $yahooResults = $this->__profileDoYahoo($company);
                }catch(Exception $e){
                    $connect['yahoo'] = false;
                }    
                
            }catch(Exception $e){
                $connect['yahoo'] = false;
            }
                        
            //Do we have a configuration defined for Yelp?
            try{
               $connect['yelp'] = ConnectionManager::getDataSource('yelp');
               
                //Yes, Yelp has a configuration defined.
                //Can we get any results from Yelp?
                try{
                    $yelpResults = $this->__profileDoYelp($company);
                }catch(Exception $e){
                    $connect['yelp'] = false;
                }                
               
            }catch(Exception $e){
                $connect['yelp'] = false;
            }    
                        
            
            //Do we have a configuration for Google?
            try{
                
                $connect['google'] = ConnectionManager::getDataSource('google');
                
                //Yes, Google has a configuration defined.
                //Can we get any results from Goolge?
                 try{
                    $connect['google'] = false; //Auto fail Google until we get it set up
                    $googleResults = array();
                }catch(Exception $e){
                    $connect['google'] = false;
                }
                
            }catch(Exception $e){
                $connect['google'] = false;
            }  
        }

        $webResults = array(
            'yahoo' => $yahooResults,
            'yelp' => $yelpResults,
            'google' => $googleResults
        );

        $this->set('webResults', $webResults);
        $this->set('company', $company);
        
        //Are we looking at "MY" account? (Where "MY" == the logged in user.)
        if($this->Session->read('Auth.User.id') == $company['ProfileCompany']['owner_person_id']){
            $mine = true;
        }        
        
        $this->set('mine', $mine);
        $this->set('connect', $connect);
        $this->set('title_for_layout', $company['ProfileCompany']['name']);
    }

    /**
     * Action method to display a form for creating a new company profile
     *
     * @access public
     */
    public function create() 
    {
        $userProfile = $this->Person->fetchPersonWith($this->Session->read('Auth.User.username'), 'Profile');
        $this->set('userProfile', $userProfile);
        $this->set('title_for_layout', __('Create a company'));
    }

    /**
     * Action method to display a form for creating a new company profile
     *
     * @access public
     */
    public function edit($slug) {
        
        $mine = false;
        
        $this->data = $this->ProfileCompany->fetchCompanyWith($slug, array('Address'));
        
        $userProfile = $this->Person->fetchPersonWith($this->Session->read('Auth.User.username'), 'Profile');
        $this->set('userProfile', $userProfile);
        
        
        //Are we looking at "MY" account? (Where "MY" == the logged in user.)
        if($this->Session->read('Auth.User.id') == $this->data['ProfileCompany']['owner_person_id']){
            $mine = true;
        }        
        
        $this->set('mine', $mine);
        $this->set('title_for_layout', "Update {$this->data['ProfileCompany']['name']}");
    }
    
    /**
     * Action to save a company profile
     *
     * @access public
     */
    public function save()
    {

        $companyData = $this->data;
        $companyData['ProfileCompany']['owner_person_id'] = $this->Session->read('Auth.User.id');

        if($this->ProfileCompany->saveAll($companyData)) {

            $this->Session->setFlash(__('The company details were saved successfully'), 'success');

            $userId = $this->Session->read('Auth.User.id');
            
            if(isset($this->params['named']['goto'])){
                
                $company = $this->ProfileCompany->find('first',
                        array(
                            'conditions'=> array('ProfileCompany.id'=>$this->ProfileCompany->id),
                            'contain'=>array()
                        )); 

                $this->redirect("/profile_companies/edit/{$company['ProfileCompany']['slug']}");
            }

        } else {
            $this->Session->setFlash(__('There was a problem saving the company details'), 'error');
            $this->redirect('/profile_companies/create');
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
        if($this->ProfileCompany->delete($companyId, true /* cascade */)) {
            $this->Session->setFlash(__('The company was deleted successfully'), 'success');
        } else {
            $this->Session->setFlash(__('There was a problem deleting the company'), 'error');
        }


        $this->redirect('/profile_companies/index');
    }


    /**
     * Helper function to fetch Yahoo Local Search listings for the given company
     *
     * @access private
     * @param ProfileCompany company object to use for pulling listing data from Yahoo
     * @return mixed
     */
    private function __profileDoYahoo($company)
    {

        if(
            isset($company['ProfileCompany']['yahoo_listing_id']) &&
            !empty($company['ProfileCompany']['yahoo_listing_id'])
        ) {
            $requestParams = array(
                'query' => '*',
                'listing_id' => $company['ProfileCompany']['yahoo_listing_id']
            );
        } else {

            if(isset($company['Address']) && !empty($company['Address'])) {
                $requestParams = array(
                    'query' => $company['ProfileCompany']['name'],
                    'location' => $company['Address'][0]['_us_full_address']
                );
            } else {
                $requestParams = array(
                    'query' => $company['ProfileCompany']['name']
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
     * @access private
     * @param ProfileCompany company object to use for pulling listing data from Yahoo
     * @return mixed
     */
    private function __profileDoYelp($company)
    {
        $queryTerms = array(
            'limit' => 5,
            'term' => $company['ProfileCompany']['name']
        );

        if(isset($company['Address']) && !empty($company['Address'])) {
            $queryTerms['location'] = $company['Address'][0]['_us_full_address'];
        }

        $results = $this->YelpApi->find('all', array(
            'conditions' => $queryTerms
        ));

        return $results;
    }
    
    /**
     * Admin index action to list all companies
     *
     * @access public
     */
    public function admin_index()
    {
        //Show all accounts
        $companies = $this->Company->fetchAllCompaniesWith(array('Address'));
        //Make the comopany array look like the person array            
        $companies = Set::extract('/Company/.',$companies);
           
        $this->set('companies', $companies);
        $this->set('title_for_layout', __('Company Index')); 
 
    }    
    
}
