<?php

App::uses('AppController', 'Controller');

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
    public $uses = array('Company');


    /**
     * Default index action method to list all companies
     *
     * @access public
     */
    public function index()
    {
        $companies = $this->Company->fetchAllCompanies();
        $this->set('companies', $companies);
    }


    /**
     * Action method to view a single company's profile using its name
     *
     * @access public
     */
    public function view($companyName)
    {
        $company = $this->Company->fetchCompanyByName($companyName);
        $this->set('company', $company);
    }


    /**
     * Action method to display a form for creating a new company profile
     *
     * @access public
     */
    public function create() {}


    /**
     * Action method to save a new company record and redirect to appropriate action after
     * successfull or un-successfull creation of the company record.
     *
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
