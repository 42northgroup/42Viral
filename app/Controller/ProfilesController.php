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

    /**
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
     
    }

    /**
     * Provides an index of all system profiles
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
     */
    public function index()
    {
        $this->loadModel('User');
        $profiles = $this->User->find('all', array('conditions'=>array(), 'contain'=>array()));
        $this->set('profiles', $profiles);
    }
    
    /**
     * The public action for creating user accounts
     * 
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
     */
    public function user_add()
    {
        if(!empty($this->data)){
            
            $this->loadModel('User'); 

            $this->User->createUser($data['User']);
            
            $user = $this->User->findByUsername($data['User']['username']);
            
            $this->Auth->login($user);

        }
    }
    
    /* === Blog Management ========================================================================================== */
    
    /**
     * 
     */
    public function blogs(){
        $this->loadModel('Blog');
        $blogs = $this->Blog->find('all');
        $this->set('blogs', $blogs);
    }    
    
    /**
     * 
     */
    public function blog_create()
    {
        $this->loadModel('Blog');
        
        if(!empty($this->data)){
            
            if($this->Blog->save($this->data)){
                $this->Session->setFlash($this->message('Your blog has been created', 'success'));
            }else{
                $this->Session->setFlash($this->message('There was a problem creating your blog'));
            }
        }
    }
    
    /**
     * 
     */
    public function post_create($blogId = null)
    {
        
        if(is_null($blogId)){
            
            $this->loadModel('Blog');
            $blogs = $this->Blog->find('all');
            $this->set('blogs', $blogs);
            
        }else{
            $this->loadModel('Post'); 
            if(!empty($this->data)){

                if($this->Post->save($this->data)){
                    $this->Session->setFlash($this->message('You have successfully posted to your blog', 'success'));
                }else{
                    $this->Session->setFlash($this->message('There was a problem posting to your blog'));
                }

            }     
            
        }
    } 
    
    /**
     * 
     */
    public function page_create()
    {
        $this->loadModel('Page');
        
        if(!empty($this->data)){
            
            if($this->Page->save($this->data)){
                $this->Session->setFlash($this->message('Your page has been created', 'success'));
            }else{
                $this->Session->setFlash($this->message('There was a problem creating your page'));
            }
        }
    }
    
}
