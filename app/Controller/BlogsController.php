<?php

App::uses('AppController', 'Controller');

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
    public $uses = array();


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
        $this->set('title_for_layout', 'Blogs');
    }
    
    /**
     * Displays a blog
     *
     * @param array
     */
    public function view($slug) {
        $this->loadModel('Blog');
        $blog = $this->Blog->findBySlug($slug);
        $this->set('blog', $blog);
    } 
    
    /**
     * Displays a blog post
     *
     * @param array
     */
    public function post($slug) {
        $this->loadModel('Post');
        $post = $this->Post->findBySlug($slug);
        $this->set('post', $post);
    }       
    
    
}
