<?php

App::uses('Controller', 'Controller');

/**
 *
 */
class AppController extends Controller 
{
    
    /**
     * Application wide components
     * @var type 
     * @access public
     */
    public $components = array('Auth', 'RequestHandler', 'Security');
    
    /**
     * Application-wide helpers
     * @var array
     * @access public
     */
    public $helpers = array('Form', 'Html', 'Session', 'Text');
    
    /**
     * Fires before AppController
     * @access public
     */
    public function beforeFilter()
    {
        
    }
     
    /**
     * Fires after AppController but before the action
     * @access public
     */
    public function beforeRender()
    {
        
    }   
}
