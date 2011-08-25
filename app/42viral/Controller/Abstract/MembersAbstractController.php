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
    public $uses = array('Image', 'User');
    
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
        $this->auth(array('view'));
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

        // If we have no token, we will use the logged in user.
        if(is_null($token)):
            $token = $this->Session->read('Auth.User.username');
        endif;
        
        //Get the user data
        $user = $this->User->getProfile($token);
        
        //Does the user really exist?
        if(empty($user)):
            $this->Session->setFlash(__('An invalid profile was requested') ,'error');
            //$this->redirect('/', 404);
        endif;

        // Mine
        if($this->Session->read('Auth.User.username') == $token){
            $this->set('mine', true);
        }else{
            $this->set('mine', false);
        }

        $this->set('user', $user);
        
    } 


    /**
     * Uploads an image to a users profile
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public 
     */
    public function upload_image($personId){
        
        if(!empty($this->data)){
         
            if($this->Image->upload($this->data)){
                $this->Session->setFlash('Saved!', 'success');
            }else{
                $this->Session->setFlash('Failed!', 'error');
            }
        }
        
        $this->redirect($this->referer());
    }     
    
    /**
     * Sets a user's profile image
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public 
     */
    public function set_avatar($personId, $imageId){

        $image = $this->Image->find('first', array('conditions'=>array('Image.id'=>$imageId)));
        
        $path = IMAGE_WRITE_PATH . $personId . DS . $image['Image']['name'];
        
        $this->Image->setProfileImage($path, $personId);
        
        $this->redirect($this->referer());
    }       
    
    /**
     * Sets a user's profile image
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public 
     */
    public function set_profile_image(){

    }
}