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
     * Admin index action method to list all companies
     *
     * @access public
     */
    public function admin_index()
    {
        //Show all companies
        $companies = $this->Company->fetchCompaniesWith();
                  
        $this->set('companies', $companies);
        $this->set('title_for_layout', __('Company Index')); 
        
    }   
    
    public function admin_create()
    {
        $this->request->data['Company']['name'] = 'test';
        $companies = $this->Company->save($this->data);
    }  
    
}
