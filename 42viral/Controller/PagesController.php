<?php
/**
 * Controll logic for viewing and managing web pages
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
 * @package 42viral\Content\Page
 */

App::uses('AppController', 'Controller');
/**
 * Controll logic for viewing and managing web pages
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @package 42viral\Content\Page
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
     * Helpers
     *
     * @var array
     * @access public
     */
    public $helpers = array(
        'Html',
        'Session',
        'Tags.TagCloud'
    );


    /**
     * Components
     *
     * @access public
     * @var array
     */
    public $components = array();

    /**
     * Models this controller uses
     * @var array
     * @access public
     */
    public $uses = array(
        'Page'
    );


    /**
     * beforeFilter
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();

        $this->auth(array('home', 'index', 'short_cut', 'view', 'display'));
    }

    /**
     * provides a generic call for determing the "home page"
     * @return void
     * @access public
     */
    public function home(){

        //$this->layout = 'home';
        $this->set('title_for_layout', Configure::read('Theme.HomePage.title'));
    }

    /**
     * Displays a list of public pages
     *
     * @access public
     * @return void
     */
    public function index() {

        //If we found the target blog, retrive an paginate its' posts
        $this->paginate = array(
            'conditions' => array(
                'Page.status'=>array('archived', 'published')
            ),
            'fields'=>array(
                'Page.id',
                'Page.body',
                'Page.object_type',
                'Page.slug',
                'Page.syntax',
                'Page.title',
                'Page.url'
            ),
            'limit' => 10,
            'order'=>'Page.title ASC'
        );

        $pages = $this->paginate('Page');
        $this->set('pages', $pages);
        $this->set('title_for_layout', 'Pages');
    }

    /**
     * Displays a list of pages, including drafts
     *
     * @access public
     * @return void
     */
    public function admin_index() {

        //If we found the target blog, retrive an paginate its' posts
        $this->paginate = array(
                'conditions' => array(),
                'fields'=>array(
                        'Page.id',
                        'Page.body',
                        'Page.status',
                        'Page.slug',
                        'Page.syntax',
                        'Page.title',
                        'Page.url'
                ),
                'limit' => 10,
                'order'=>'Page.title ASC'
        );

        $pages = $this->paginate('Page');
        $this->set('pages', $pages);
        $this->set('title_for_layout', 'Pages');
    }
    /**
     * Redirect short links to their proper url
     * @access public
     * @param string $shortCut
     * @return void
     */
    public function short_cut($shortCut) {
        //$page = $this->Page->getPageWith($shortCut, 'nothing');
        $page = $this->Page->find('first', array(
            'conditions'=>array('or' => array(
                'Page.id' => $shortCut,
                'Page.slug' => $shortCut,
                'Page.short_cut' => $shortCut
            )),
            'contain' => array()
        ));

        //Avoid Google duplication penalties by using a 301 redirect
        $this->redirect($page['Page']['canonical'], 301);
    }

    /**
     * Displays a webpage excludes drafts
     *
     * @param string $slug the slug of the page we want to view
     * @return void
     * @access public
     */
    public function view($slug) {

        $page = $this->Page->find(
            'first',
            array(
                'conditions'=>array(
                    'Page.slug'=>$slug,
                    'Page.status'=>array('archived', 'published')
                ),
                'fields'=>array(
                    'Page.id',
                    'Page.title',
                    'Page.canonical',
                    'Page.syntax',
                    'Page.body'
                ),
                'contain'=>array()
            )
        );

        $this->_isResultSet($page);

        $this->set('title_for_layout', $page['Page']['title']);
        $this->set('canonical_for_layout', $page['Page']['canonical']);
        $this->set('page', $page);

        $this->set('tags', $this->Page->Tagged->find('cloud', array('limit' => 10)));
    }


    /**
     * Displays a webpage, including drafts
     *
     * @param string $slug the slug of the page we want to view
     * @return void
     * @access public
     */
    public function admin_view($slug) {

        $this->_validRecord('Page', $slug, 'slug');

        $page = $this->Page->find(
            'first',
            array(
                'conditions'=>array(
                    'Page.slug'=>$slug
                ),
                'fields'=>array(
                    'Page.id',
                    'Page.title',
                    'Page.canonical',
                    'Page.syntax',
                    'Page.body'
                ),
                'contain'=>array()
            )
        );

        $this->_isResultSet($page);

        $this->set('title_for_layout', $page['Page']['title']);
        $this->set('canonical_for_layout', $page['Page']['canonical']);
        $this->set('page', $page);

        $this->set('tags', $this->Page->Tagged->find('cloud', array('limit' => 10)));
    }

    /**
     * Displays a view
     *
     * @return void
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
     * Creates a traditional web page
     *
     * @return void
     * @access public
     */
    public function admin_create()
    {

        if(!empty($this->data)){
            $this->request->data['Sitemap']['model'] = 'Page';
            if($this->Page->saveAll($this->data)){
                $this->Session->setFlash(__('Your page has been created'), 'success');
                $this->redirect("/admin/pages/edit/{$this->Page->id}");
            }else{
                $this->Session->setFlash(__('There was a problem creating your page'), 'error');
            }
        }

        $this->set('title_for_layout', __('Create a Page'));

    }


    /**
     * Updates a web page
     *
     * @param string $id
     * @return void
     * @access public
     */
    public function admin_edit($id)
    {
        if(!empty($this->data)){

            //If we are saving as Markdown just check the body for malice
            if (isset($this->data['Page']['syntax']) && $this->data['Page']['syntax'] == 'markdown') {
                $this->Page->Behaviors->attach(
                'Scrubable',
                array('Filters'=>array(
                        'trim'=>'*',
                        'safe' => array('body'),
                        'noHTML'=>array(
                            'canonical',
                            'title',
                            'description',
                            'id',
                            'keywords',
                            'short_cut',
                            'syntax'
                        ),
                    )
                )
                );
            }

            if($this->Page->saveAll($this->data)){
                $this->Session->setFlash(__('Your page has been updated'), 'success');
            }else{
                $this->Session->setFlash(__('There was a problem updating your page'), 'error');
            }
        }

        //$this->data = $this->Page->getPageWith($id, 'edit');
        $this->data = $this->Page->find('first', array(
        	'conditions'=>array('or' => array(
                'Page.id' => $id,
                'Page.slug' => $id,
                'Page.short_cut' => $id
            )),
            'contain' => array(
                'Tag',
                'Sitemap'
            )
        ));

        $this->set('statuses', $this->Page->listPublicationStatus());
        $this->set('title_for_layout', "Edit ({$this->data['Page']['title']})");
    }

    /**
     * Removes a web page
     *
     * @access public
     * @param $id ID of the page we want to delete
     * @return void
     */
    public function admin_delete($id){

        if($this->Page->delete($id)){
            $this->Session->setFlash(__('Your page has been removed'), 'success');
            $this->redirect($this->referer());
        }else{
           $this->Session->setFlash(__('There was a problem removing your page'), 'error');
           $this->redirect($this->referer());
        }

    }
}