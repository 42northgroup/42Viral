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
     * @return void
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
     
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
        $profiles = $this->User->find('all', array('conditions'=>array(), 'contain'=>array()));
        $this->set('profiles', $profiles);
        
    }
    
    /**
     * Creates a user account using user submitted input
     * Logs the newly created user into the system
     * 
     * @return void
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
     * A index of all blogs
     * 
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
     */
    public function blogs(){
        $this->loadModel('Blog');
        $blogs = $this->Blog->find('all');
        $this->set('blogs', $blogs);
    }    
    
    /**
     * Removes a blog and all related posts
     * 
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
     */
    public function blog_delete($id){
        
        $this->loadModel('Blog');
        
        if($this->Blog->delete($id)){
            $this->Session->setFlash(__('Your blog and blog posts have been removed'), 'success');
            $this->redirect($this->referer());
        }else{
           $this->Session->setFlash(__('There was a problem removing your blog'), 'error'); 
           $this->redirect($this->referer());
        }

    }       
    
    /**
     * Creates a blog - a blog contains a collection of posts
     * 
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
     */
    public function blog_create()
    {
        $this->loadModel('Blog');
        
        if(!empty($this->data)){
            
            if($this->Blog->save($this->data)){
                $this->Session->setFlash(__('Your blog has been created'), 'success');
            }else{
                $this->Session->setFlash(__('There was a problem creating your blog'), 'error');
            }
        }
    }
    
    /**
     * Removes a post
     * 
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
     */
    public function post_delete($id){
        
        $this->loadModel('Post');
        
        if($this->Post->delete($id)){
            $this->Session->setFlash(__('Your post has been removed'), 'success');
            $this->redirect($this->referer());
        }else{
           $this->Session->setFlash(__('There was a problem removing your post'), 'error'); 
           $this->redirect($this->referer());
        }

    }
    
    /**
     * Creates a post or blog entry
     * 
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
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
                    $this->Session->setFlash(__('You have successfully posted to your blog'), 'success');
                }else{
                    $this->Session->setFlash(__('There was a problem posting to your blog'), 'error');
                }

            }     
            
        }
    }
    
    /**
     * Removes a web page
     * 
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
     */
    public function page_delete($id){
        
        $this->loadModel('Page');
        
        if($this->Page->delete($id)){
            $this->Session->setFlash(__('Your page has been removed'), 'success');
            $this->redirect($this->referer());
        }else{
           $this->Session->setFlash(__('There was a problem removing your page'), 'error'); 
           $this->redirect($this->referer());
        }

    }    
    
    /**
     * Creates a traditional web page
     * 
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
     */
    public function page_create()
    {
        $this->loadModel('Page');

        if(!empty($this->data)){

            if($this->Page->save($this->data)){
                $this->Session->setFlash(__('Your page has been created'), 'success');
            }else{
                $this->Session->setFlash(__('There was a problem creating your page'), 'error');
            }
        }
    }
    
    /**
     * Displays a list of all content created by a single user
     *
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
     */
    public function content() {
        $this->loadModel('Content');
        
        $contents = $this->Content->find('all', 
                array('conditions'=>array(
                    'Content.created_person_id' => $this->Session->read('Auth.User.User.id'))));
                
        $this->set('contents', $contents);
    }   
    
    
    
}
