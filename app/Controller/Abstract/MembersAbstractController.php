<?php

App::uses('AppController', 'Controller');

/**
 *
 */
abstract class MembersAbstractController extends AppController {

    /**
     * Controller name
     * @var string
     * @access public
     */
    public $name = 'Members';
    
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
    public $helpers = array('Member');
    
    /**
     * @return void
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
     
        $this->Auth->allow('view');
    }

    /**
     * Provides an index of all system profiles
     * 
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
     */
    public function index()
    {
        $this->loadModel('User');
        $users = $this->User->find('all', array('conditions'=>array(), 'contain'=>array()));
        $this->set('users', $users);
    }
    
    /**
     * My profile
     * 
     * @param string $finder
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
     */
    public function view($token = null)
    {
        
        if(!empty($this->data)){
            
            $this->loadModel('Image');
            if($this->Image->upload($this->data)){
                $this->Session->setFlash('Saved!', 'success');
            }else{
                $this->Session->setFlash('Failed!', 'error');
            }
        }

        //If we have no token, we will use the logged in user.
        if(is_null($token)){
            $token = $this->Session->read('Auth.User.User.username');
            if(empty($token)):
                $this->Session->setFlash(__('An invalid profile was requested') ,'error');
                $this->redirect('/users/login');
            endif;
        }
        
        $this->loadModel('User');
        $user = $this->User->getProfile($token);
        $this->set('user', $user);
        
    } 
    
    /**
     * Sets a user's profile image
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public 
     */
    public function set_profile_image(){
        $this->loadModel('User');
    }    
}