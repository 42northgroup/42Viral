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
 class AccountsController extends AppController
{
   /**
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();
    }

    /**
     * Admin index action method to list all accountss
     *
     * @access public
     */
    public function admin_index()
    {
        //Show all accounts
        $accounts = $this->Account->fetchAccountsWith();
                  
        $this->set('accounts', $accounts);
        $this->set('title_for_layout', __('Accounts (CRM)')); 
        
    }   
    
    /**
     * Provides the control logic for the accounts creation logic
     * @return void
     * @access public
     */
    public function admin_create()
    {
        if(!empty($this->data)){
            if($this->Account->save($this->data)){
                $this->Session->setFlash(__('The account has been added'), 'success');
                $account = $this->Account->fetchAccountWith($this->Account->id);
                $this->redirect($account['Account']['admin_view_url']);    
            }else{
                $this->Session->setFlash(__('Please correct the errors below'), 'error');    
            }
        }
        $this->set('title_for_layout', __('Create a Account'));        
    }  
    
    
    public function admin_edit($id)
    {
        if(!empty($this->data)){
            if($this->Account->save($this->data)){
                $this->Session->setFlash(__('The account has been added'), 'success');

            }else{
                $this->Session->setFlash(__('Please correct the errors below'), 'error');    
            }
        }
        
        $this->request->data = $this->Account->fetchAccountWith($id);
        $this->set('title_for_layout', $this->data['Account']['name'] .' ' . __('(Edit)'));        
    }  
    
    public function admin_view($id){
        $account = $this->Account->fetchAccountWith($id);
        $this->set('title_for_layout', $account['Account']['name'] .' ' . __('(View)'));    
    }
    
    public function admin_delete($id){
        if($this->Account->delete($id)){
            $this->Session->setFlash(__('The account has been deleted'), 'success');
            $this->redirect($this->referer());
        }else{
            $this->Session->setFlash(__('The account could not be deleted'), 'error');
            $this->redirect($this->referer());
        }
    }    
}
