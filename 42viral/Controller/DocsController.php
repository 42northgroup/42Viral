<?php
/**
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppController', 'Controller');

/**
 * @package app
 * @subpackage app.core
 */
class DocsController extends AppController {

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
    public $helpers = array(
        //'Tags.TagCloud'
    );

    /**
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();
        //$this->auth(array('index', 'view'));
    }

    /**
     *
     * @return void
     * @access public
     */
    public function index() {}


    /**
     * Displays a blog
     *
     * @param array
     */
    public function view($slug) {
        /*
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

        if($this->Session->read('Auth.User.id') == $blog['Blog']['created_person_id']){
            $mine = true;
        }

        $this->set('mine', $mine);

        $this->set('tags', $this->Blog->Tagged->find('cloud', array('limit' => 10)));
        */
    }
}
