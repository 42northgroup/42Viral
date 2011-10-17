<?php

App::uses('AppController', 'Controller');

/**
 *
 */
 class PagesController extends AppController {

    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Pages';

    /**
     * Default helper
     *
     * @var array
     * @access public
     */
    public $helpers = array('Html', 'Session', 'Tags.TagCloud');

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
        
        $this->auth(array('*'));
    }
    /**
     * Displays a list of blogs
     *
     * @param array
     */
    public function index() {
        
        $this->loadModel('Page');
        $pages = $this->Page->find('all');
        
        $this->set('pages', $pages);
        $this->set('title_for_layout', 'Pages');
    } 
    
    /**
     * Displays a blog post
     *
     * @param array
     */
    public function view($slug) {
        $this->loadModel('Page');
        $page = $this->Page->fetchPageWith($slug);
        
        if(empty($page)){
           $this->redirect('/', '404');
        }
        
        $this->set('title_for_layout', $page['Page']['title']);        
        $this->set('canonical_for_layout', $page['Page']['canonical']);
        $this->set('page', $page); 
        
        $this->set('tags', $this->Page->Tagged->find('cloud', array('limit' => 10)));
    }  
    
    /**
     * Displays a view
     *
     * @param mixed What page to display
     */
    public function display() {
        $path = func_get_args();

        $count = count($path);
        if (!$count) {
                $this->redirect('/');
        }
        $page = $subpage = $title_for_layout = null;

        if (!empty($path[0])) {
                $page = $path[0];
        }
        if (!empty($path[1])) {
                $subpage = $path[1];
        }
        if (!empty($path[$count - 1])) {
                $title_for_layout = Inflector::humanize($path[$count - 1]);
        }
        $this->set(compact('page', 'subpage', 'title_for_layout'));
        $this->render(implode('/', $path));
    }
    
    /**
     * 
     */
    public function home(){
        $this->layout = 'home';
        $this->set('title_for_layout', Configure::read('Theme.HomePage.title'));
    }
}