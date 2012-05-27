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
 * @package 42viral\Content\Blog
 */

App::uses('AppController', 'Controller');
App::uses('ProfileUtil', 'Lib');
/**
 * Provides the controll logic for creating, viewing and managing blogs
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @package 42viral\Content\Blog
 */
class BlogsController extends AppController {

    /**
     * Model this controller uses
     *
     * @var array
     * @access public
     */
    public $uses = array(
        'Blog', 
        'Conversation', 
        'Post', 
        'Person', 
        'PicklistManager.Picklist',
        'Profile'
    );
    
    /**
     * Helpers
     * @var array
     * @access public
     */
    public $helpers = array(
        'Profile', 
        'Tags.TagCloud'
    );

    /**
     * Components
     * @access public
     * @var array
     */
    public $components = array(
        'HtmlFromDoc.CakeDocxToHtml',
        'FileUpload.FileUpload'
    );

    /**
     * beforeFilter
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();
        $this->auth(array('index', 'short_cut', 'view'));
        $this->prepareDocUpload('Blog');
    }

    /**
     * Displays a list of published blogs. The scop can be all published or all published blogs beloning to a single
     * user.
     *
     * @param string $username the username for any system user
     *
     * @access public
     */
    public function index($username = null) {
        
        $showAll = true;
        $pageTitle = 'Blog Index';
        
        if(is_null($username)){
            $blogs = $this->Blog->fetchBlogsWith();
        }else{
            
            $profile = $this->Person->getPersonWith($username, 'blog');
            
            if (empty($profile)) {
                throw new NotFoundException("{$username} " . __("doesn't seem to exist"));
            }
            
            $blogs = $profile;
            $showAll = false;
            $pageTitle = ProfileUtil::name($profile['Person']) . "'s Blogs";
            $this->set('userProfile', $profile);
            
        }
        
        $this->set('showAll', $showAll);
        $this->set('blogs', $blogs);
        $this->set('title_for_layout', $pageTitle);
        
    }

    /**
     * Resirect short links to their proper url
     * @param string $shortCut 
     */
    public function short_cut($shortCut) {

        $blog = $this->Blog->fetchBlogWith($shortCut, 'nothing');
        
        //Avoid Google duplication penalties by using a 301 redirect
        $this->redirect($blog['Blog']['canonical'], 301);
    }  
    
    /**
     * Displays a blog
     *
     * @param array
     */
    public function view($slug) {
       
        $mine = false;
        
        //Find the target blog
        $blog = $this->Blog->getBlogWith($slug, 'view');

        //Does the target blog exist
        if(empty($blog)){
           $this->redirect('/', '404');
        }
        
        //If we found the target blog, retrive an paginate its' posts
        $this->paginate = array(
            'conditions' => array(
                'Post.parent_content_id'=>$blog['Blog']['id'],
                'Post.status'=>array('archived', 'published')
            ),
            'limit' => 10,
            'order'=>'Post.created DESC'
        );

        $posts = $this->paginate('Post');

        
        if($this->Session->read('Auth.User.id') == $blog['Blog']['created_person_id']){
            $mine = true;
        }

        $userProfile['Person'] = $blog['CreatedPerson'];
                if($this->Session->read('Auth.User.id') == $blog['Blog']['created_person_id']){
            $mine = true;
        }
        
        $this->set('title_for_layout', $blog['Blog']['title']);
        $this->set('canonical_for_layout', $blog['Blog']['canonical']);
        $this->set('blog', $blog);
        $this->set('posts', $posts);                           
        $this->set('userProfile', $userProfile);
        $this->set('mine', $mine);
        $this->set('tags', $this->Blog->Tagged->find('cloud', array('limit' => 10)));
    } 

    /**
     * Removes a blog and all related posts
     * 
     * @access public
     * @param $id ID of the blog we want to delete
     *
     */
    public function delete($id){
        
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
     *
     * @access public
     */
    public function create()
    {
        
        if(!empty($this->data)){
            
            if($this->Blog->save($this->data)){
                $this->Session->setFlash(__('Your blog has been created'), 'success');
                $this->redirect("/blogs/edit/{$this->Blog->id}");
            }else{
                $this->Session->setFlash(__('There was a problem creating your blog'), 'error');
            }
        }
        
        $this->set('title_for_layout', 'Create a Blog');
        
        
    }
    
    /**
     * Creates a blog - a blog contains a collection of posts
     * 
     * @param string $id
     *
     * @access public
     */
    public function edit($id)
    {
        if(!empty($this->data)) {
            if($this->FileUpload->uploadDetected) {
                $this->request->data['Blog']['body'] =
                    $this->CakeDocxToHtml->convertDocumentToHtml($this->FileUpload->finalFile, true);

                $this->FileUpload->removeFile($this->FileUpload->finalFile);
            }
            
            //If we are saving as Markdown, don't allow any HTML
            if($this->data['Blog']['syntax']=='markdown'){
                $this->Blog->Behaviors->attach(
                        'ContentFilters.Scrubable', 
                        array('Filters'=>array(
                                    'trim'=>'*',
                                    'noHTML'=>array('id', 'tease', 'title', 'description', 'keywords', 'canonical', 
                                        'syntax', 'short_cut', 'body'),
                                )
                            )
                        );
            }
            
            if($this->Blog->save($this->data)){
                $this->Session->setFlash(__('Your blog has been created'), 'success');
            }else{
                $this->Session->setFlash(__('There was a problem creating your blog'), 'error');
            }
        }else{
            //We only want to fire this if the data array is empty
            $this->data = $this->Blog->findById($id);
        }
        
        $this->set('statuses', 
                $this->Picklist->fetchPicklistOptions(
                        'publication_status', array('emptyOption'=>false, 'otherOption'=>false)));
        
        $this->set('title_for_layout', "Update {$this->data['Blog']['title']}");    
        
    }    
    
    
}
