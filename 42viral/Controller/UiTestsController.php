<?php

App::uses('AppController', 'Controller');

/**
 * @package app
 * @subpackage app.core
 */
 class UiTestsController extends AppController
{

    /**
     * This controller does not use a model
     *
     * @var array
     * @access public
     */
    public $uses = array();


    /**
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('*');
    }

    /**
     * @access public
     */
    public function beforeRender()
    {
        parent::beforeRender();
        $this->layout = 'qunit';
    }
    
    /**
     *
     * @param array
     */
    public function index() 
    {

    }
    
    
    /**
     *
     * @param array
     */
    public function example() 
    {

    }

}
