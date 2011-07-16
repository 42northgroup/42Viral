<?php

App::uses('Controller', 'Controller');

/**
 *
 */
class AppAbstractController extends Controller 
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
    public $helpers = array('Form', 'Html', 'Session', 'Text');
    
    /**
     * Fires before AppController
     * @access public
     */
    public function beforeFilter()
    {
        
        //We only want to pull a custom theme if it's not a "Special Document" type
        if(in_array($this->RequestHandler->ext, Router::extensions())){
            $this->layoutPath = $this->RequestHandler->ext;
        }else{
           $this->layout = 'Themes' . DS . 'Default' . DS . 'default'; 
        }       
        
        if($this->Session->check('Auth.User.User.id')){
            $this->Auth->allow('*');
        }

    }
     
    /**
     * Fires after AppController but before the action
     * @access public
     */
    public function beforeRender()
    {
        
    }    
}
