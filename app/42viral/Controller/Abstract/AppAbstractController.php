<?php

App::uses('Controller', 'Controller');
App::uses('File', 'Utility');

/**
 *
 */
abstract class AppAbstractController extends Controller 
{
    /**
     * Application wide components
     * @var type 
     * @access public
     */
    public $components = array('Auth', 'RequestHandler', 'Security', 'Session');
    
    /**
     * Application-wide helpers
     * @var array
     * @access public
     */
    public $helpers = array('Asset', 'Form', 'Html', 'Session', 'Text');
    
    /**
     * Fires before AppController
     * This is a good place for loading data and running security checks
     * @access public
     */
    public function beforeFilter()
    {
        if($this->Session->check('Auth.User.id')){
            $this->Auth->allow('*');
        }   
    }
     
    /**
     * Fires after AppController but before the action
     * This is a good place for calling themes
     * @access public
     */
    public function beforeRender()
    { 
        $this->viewClass = 'Theme';
        $this->theme = THEME_SET;
        
    }    
}