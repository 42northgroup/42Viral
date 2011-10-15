<?php

App::uses('AppController', 'Controller');
App::uses('Member', 'Lib');

/**
 * @package app
 * @subpackage app.core
 */
class BlogsController extends AppController {

    /**
     * This controller does not use a model
     *
     * @var array
     * @access public
     */
    public $uses = array('Blog', 'Post', 'Person', 'Profile');
    
    /**
     * @var array
     * @access public
     */
    public $helpers = array('Member', 'Tags.TagCloud');

    /**
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();
        $this->auth(array('*'));

    }

    /**
     * Displays a list of published blogs. The scop can be all published or all published blogs beloning to a single
     * user.
     *
     * @param string $username the username for any system user
     * @return void
     * @access public
     */
    public function index($username = null) {
        
        $showAll = true;
        $pageTitle = 'Blog Index';
        
        if(is_null($username)){
            $blogs = $this->Blog->fetchBlogsWith();
        }else{
            
            $profile = $this->Person->fetchPersonWith($username, 'blog');
            
            if (empty($profile)) {
                throw new NotFoundException("{$username} " . __("doesn't seem to exist"));
            }
            
            $blogs = $profile;
            $showAll = false;
            $pageTitle = Member::name($profile['Person']) . "'s Blogs";
            $this->set('userProfile', $profile);
            
        }
        
        $this->set('showAll', $showAll);
        $this->set('blogs', $blogs);
        $this->set('title_for_layout', $pageTitle);
        
    }
    
    /**
     * Displays a blog
     *
     * @param array
     */
    public function view($slug) {
       
        $mine = false;
        
        $blog = $this->Blog->fetchBlogWith($slug, 'standard');

        if(empty($blog)){
           $this->redirect('/', '404');
        }
        
        $this->set('title_for_layout', $blog['Blog']['title']);
        $this->set('canonical_for_layout', $blog['Blog']['canonical']);
        
        $this->set('blog', $blog);
        
        if($this->Session->read('Auth.User.id') == $blog['Blog']['created_person_id']){
            $mine = true;
        }

        $userProfile['Person'] = $blog['CreatedPerson'];
        $this->set('userProfile', $userProfile);
        $this->set('mine', $mine); 
        
        $this->set('tags', $this->Blog->Tagged->find('cloud', array('limit' => 10)));

    } 
    
    /**
     * Displays a blog post
     *
     * @param array
     */
    public function post($slug) {
        $mine = false;
        
        $post = $this->Post->fetchPostWith($slug, 'standard');    

        if(empty($post)){
           $this->redirect('/', '404');
        }
        
        if( !$this->Session->check('Auth.User.id') ){
            
            $this->Session->write('Auth.post_url', $this->here);
        }else{
            
            if( $this->Session->check('Auth.post_url') ){
                $this->Session->delete('Auth.post_url');
            }
            
            if( $this->Session->check('Auth.post_comment') ){
                
                $this->set('post_comment', $this->Session->read('Auth.post_comment') );
                $this->Session->delete('Auth.post_comment');
            }
            
        }
       
        //Build a user profile for use in the elements. The view must recive an array of $userProfile
        $userProfile['Person'] = $post['CreatedPerson'];
        $this->set('userProfile', $userProfile);
        
        $this->set('title_for_layout', $post['Post']['title']);
        $this->set('canonical_for_layout', $post['Post']['canonical']);
        
        $this->set('post', $post);

        if($this->Session->read('Auth.User.id') == $post['Post']['created_person_id']){
            $mine = true;
        }
        
        $this->set('mine', $mine);
        
        $this->set('tags', $this->Post->Tagged->find('cloud', array('limit' => 10)));
    }       
    
    
}
