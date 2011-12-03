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

/**
 * Abstract class to represent a generic company object which can be customized by subclassing from this class
 *
 * @author Jason D Snider <jason.snider@42viral.org>
 */
 class CompaniesController extends AppController
{
   /**
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();
    }

    /**
     * Admin index action method to list all companies
     *
     * @access public
     */
    public function admin_index()
    {
        //Show all companies
        $companies = $this->Company->fetchCompaniesWith();
                  
        $this->set('companies', $companies);
        $this->set('title_for_layout', __('Companies (CRM)')); 
        
    }   
    
    /**
     * Provides the control logic for the account creation logic
     * @return void
     * @access public
     */
    public function admin_create()
    {
        if(!empty($this->data)){
            if($this->Company->save($this->data)){
                $this->Session->setFlash(__('The company has been added'), 'success');
            }else{
                $this->Session->setFlash(__('Please correct the errors below'), 'error');    
            }
        }
        $this->set('title_for_layout', __('Create a Company'));        
    }  
    
    
    public function admin_edit($id)
    {
        if(!empty($this->data)){
            if($this->Company->save($this->data)){
                $this->Session->setFlash(__('The company has been added'), 'success');
            }else{
                $this->Session->setFlash(__('Please correct the errors below'), 'error');    
            }
        }
        
        $this->data = $this->Company->fetchCompanyWith($id);
        $this->set('title_for_layout', $this->data['Company Name'] .' ' . __('(Edit)'));        
    }      
    
}
