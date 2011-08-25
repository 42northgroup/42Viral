<?php

App::uses('AppController', 'Controller');

/**
 *
 */
abstract class CompaniesAbstractController extends AppController
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
        $userId = null;
        $company = null;

        if($this->Session->check('Auth.User.id')) {
            $userId = $this->Session->read('Auth.User.id');
        }

        if(!is_null($userId)) {
            $company = $this->Company->fetchUserCompany($userId);
        }

        $this->set('company', $company);
    }

    /**
     *
     *
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access public
     */
    public function create()
    {

    }


    /**
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access public
     */
    public function save()
    {

        $companyData = $this->data;
        $companyData['Company']['owner_person_id'] = $this->Session->read('Auth.User.id');

        if(isset($this->data['Company']['name'])) {
            $companyData['Company']['name_normalized'] = Inflector::underscore($this->data['Company']['name']);
        }

        if($this->Company->save($companyData)) {
            $this->Session->setFlash(__('The company details were saved successfully'), 'success');
            $this->redirect('/companies/index');
        } else {
            $this->Session->setFlash(__('There was a problem saving the company details'), 'error');
            $this->redirect('/companies/create');
        }
    }
}
