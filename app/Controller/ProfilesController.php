<?php

App::uses('AppController', 'Controller');

/**
 *
 */
class ProfilesController extends AppController {

    /**
     * Controller name
     * @var string
     * @access public
     */
    public $name = 'Profiles';
    
    /**
     * This controller does not use a model
     * @var array
     * @access public
     */
    public $uses = array();


    public function beforeFilter(){
        parent::beforeFilter();
    }

    function index()
    {
        $message = 'Testing';
        $this->set('message', $message);
        
        
        
        //$this->RequestHandler->respondAs('json');
        //$this->viewPath .= '/json';
        //$this->layoutPath = 'json';
    }
    
    public function user_add(){
        pr($this->data);
    }
}
