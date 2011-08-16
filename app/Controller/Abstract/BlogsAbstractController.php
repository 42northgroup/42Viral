<?php

App::uses('AppController', 'Controller');

/**
 * @package app
 * @subpackage app.core
 */
abstract class BlogsAbstractController extends AppController {

    /**
     * This controller does not use a model
     *
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
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('*');
    }

    /**
     * Displays a list of blogs
     *
     * @param array
     */
    public function index() {
        $this->loadModel('Blog');
        $blogs = $this->Blog->find('all');
        $this->set('blogs', $blogs);
        $this->set('title_for_layout', 'Blog');
    }
    
    /**
     * Displays a blog
     *
     * @param array
     */
    public function view($slug) {
        
        $this->loadModel('Blog');
        
        $blog = $this->Blog->fetchPublished($slug);
        
        if(empty($blog)){
           $this->redirect('/', '404');
        }
        
        $this->set('title_for_layout', $blog['Blog']['title']);     
        
        $this->set('blog', $blog);
    } 
    
    /**
     * Displays a blog post
     *
     * @param array
     */
    public function post($slug) {
        $this->loadModel('Post');
        $post = $this->Post->fetchPost($slug);    

        if(empty($post)){
           $this->redirect('/', '404');
        }
        
        $this->set('title_for_layout', $post['Post']['title']);
        
        $this->set('post', $post);
    }       
    
    
}
