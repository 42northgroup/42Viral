<?php

App::uses('AppController', 'Controller');

/**
 *
 */
abstract class CompaniesAbstractController extends AppController
{

    /**
     * Controller name
     * @var string
     * @access public
     */
    

    /**
     * This controller does not use a model
     * @var array
     * @access public
     */
    public $uses = array();

    /**
     * @var array
     * @access public
     */
    public $components = array();

    /**
     * @var array
     * @access public
     */
    public $helpers = array();

    /**
     * @return void
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
    }

}
