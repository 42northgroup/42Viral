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
 * Controll logic for viewing and managing web pages
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
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
     * 
     *
     * @access public
     * @var array
     */
    public $components = array(
        'HtmlFromDoc.CakeDocxToHtml',
        'FileUpload.FileUpload'
    );

    /**
     *
     * @var array
     * @access public
     */
    public $uses = array(
        'Page',
        'PicklistManager.Picklist'
    );


    /**
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();
        
        $this->auth(array('home', 'index', 'short_cut', 'view', 'display'));
        $this->prepareDocUpload('Page');
    }
    
    /**
     * provides a generic call for determing the "home page"
     * @return void
     * @access public
     */
    public function home(){
        
        $this->layout = 'home';
        $this->set('title_for_layout', Configure::read('Theme.HomePage.title'));
    }    
    
    /**
     * Displays a list of pages
     *
     * @param array
     */
    public function index() {
        
        $pages = $this->Page->fetchPagesWith();
        $this->set('pages', $pages);
        $this->set('title_for_layout', 'Pages');
    } 

    /**
     * Resirect short links to their proper url
     * @param type $shortCut 
     * @return void
     */
    public function short_cut($shortCut) {

        $page = $this->Page->getPageWith($shortCut, 'nothing');

        //Avoid Google duplication penalties by using a 301 redirect
        $this->redirect($page['Page']['canonical'], 301);
    }  
    
    /**
     * Displays a blog post
     *
     * @param array
     * @return void
     * @access public
     */
    public function view($slug) {
        $page = $this->Page->getPageWith($slug);
        
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
     * Displays a list of blogs
     *
     * @param array
     */
    public function admin_index() {
        
        $pages = $this->Page->fetchPagesWith('nothing');

        $this->set('pages', $pages);
        $this->set('title_for_layout', 'Pages');
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
            if($this->FileUpload->uploadDetected) {
                $this->request->data['Page']['body'] =
                    $this->CakeDocxToHtml->convertDocumentToHtml($this->FileUpload->finalFile, true);

                $this->FileUpload->removeFile($this->FileUpload->finalFile);
            }

            //If we are saving as Markdown just check the body for malice
            if ($this->data['Page']['syntax'] == 'markdown') {
                $this->Page->Behaviors->attach(
                    'ContentFilters.Scrubable', array(
                        'Filters' => array(
                            'trim' => '*',
                            'safe' => array('body'),
                            'noHTML' => array(
                                'id', 'tease', 'title', 'description', 'keywords', 'canonical','syntax', 'short_cut'
                            ),
                        )
                ));
            }
            
            if($this->Page->saveAll($this->data)){
                $this->Session->setFlash(__('Your page has been updated'), 'success');
            }else{
                $this->Session->setFlash(__('There was a problem updating your page'), 'error');
            }
        }
        
        $this->data = $this->Page->getPageWith($id, 'edit');
        
        
        $this->set('statuses', 
                $this->Picklist->fetchPicklistOptions(
                        'publication_status', array('emptyOption'=>false, 'otherOption'=>false)));
     
        $this->set('title_for_layout', "Edit ({$this->data['Page']['title']})");        
    } 
    
    /**
     * Removes a web page
     * 
     * @return void
     * @access public
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