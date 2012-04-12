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
App::uses('Member', 'Lib');
/**
 * Provides controll logic for managing blog post actions
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 */
class PostsController extends AppController {

    /**
     * This controller does not use a model
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
     * @var array
     * @access public
     */
    public $helpers = array(
        'Member', 
        'Tags.TagCloud'
    );

    /**
     * @access public
     * @var array
     */
    public $components = array(
        'HtmlFromDoc.CakeDocxToHtml',
        'FileUpload.FileUpload'
    );

    /**
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();
        $this->auth(array('*'));
        $this->prepareDocUpload('Post');
    }
    
    /**
     * Removes a post
     * 
     * @return void
     * @access public
     */
    public function delete($id){

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
     * @access public
     */
    public function create($blogId = null)
    {
        
        if(is_null($blogId)){

            $blogs = $this->Blog->find('all');
            $this->set('blogs', $blogs);
            
        }else{

            if(!empty($this->data)){

                if($this->Post->save($this->data)){
                    $this->Session->setFlash(__('You have successfully posted to your blog'), 'success');
                    $this->redirect("/posts/edit/{$this->Post->id}");
                }else{
                    $this->Session->setFlash(__('There was a problem posting to your blog'), 'error');
                }

            }     
            
        }
        
        $this->set('title_for_layout', 'Post to a Blog');
    }
    
    /**
     * Creates a post or blog entry
     * 
     * @param string $id
     * @return void
     * @access public
     */
    public function edit($id)
    {
        if(!empty($this->data)){
            if($this->FileUpload->uploadDetected) {
                $this->request->data['Post']['body'] =
                    $this->CakeDocxToHtml->convertDocumentToHtml($this->FileUpload->finalFile, true);

                $this->FileUpload->removeFile($this->FileUpload->finalFile);
            }

            if($this->Post->save($this->data)){
                $this->Session->setFlash(__('You have successfully posted to your blog'), 'success');
            }else{
                $this->Session->setFlash(__('There was a problem posting to your blog'), 'error');
            }
        }  
        
        $this->data = $this->Post->getPostWith($id, 'for_edit');
        
        $this->set('statuses', 
                $this->Picklist->fetchPicklistOptions(
                        'publication_status', array('emptyOption'=>false, 'otherOption'=>false)));

        $themePath = ROOT . DS . APP_DIR . DS . 'View' . DS . 'Themed' . DS 
                . Configure::write('Theme.set', 'Default') . DS;

        $unthemedPath = ROOT . DS . APP_DIR . DS . 'View' . DS;
        $relativeCustomPath = '42viral' . DS . 'Posts' . DS . 'Custom' . DS; 
        
        $themed = $themePath . $relativeCustomPath;
        $unthemed = $unthemedPath . $relativeCustomPath;
        
        $paths = array();
        
        if(is_dir($themed)){
            foreach($this->File->scan($themed) as $key => $value){
                if(is_file($themed . $value . '.ctp')){
                    $paths[$key] = $value;
                }
            }
        }
        
        if(is_dir($unthemed)){
            foreach($this->File->scan($unthemed) as $key => $value){
                if(is_file($unthemed . $value . '.ctp')){
                    $paths[$key] = $value;
                }
            }
        }

        $this->set('customFiles', $paths);
        $this->set('title_for_layout', "Edit {$this->data['Post']['title']}");
    }

    /**
     * Resirect short links to their proper url
     * @param type $shortCut 
     * @return void
     */
    public function short_cut($shortCut) {

        $post = $this->Post->getPageWith($shortCut, 'nothing');

        //Avoid Google duplication penalties by using a 301 redirect
        $this->redirect($post['Post']['canonical'], 301);
    }  
    
    /**
     * Displays a blog post
     *
     * @param array
     * @access public
     */
    public function view($slug) {
        $mine = false;
               
        $post = $this->Post->getPostWith($slug, 'standard');    

        if(empty($post)){
           $this->redirect('/', '404');
        }

        //Add a comment
        if($this->data){   
            
            if($this->Conversation->save($this->data)){
                $this->Session->setFlash(_('Your comment has been saved') ,'success');
                $this->redirect($this->referer());
            }else{
                $this->Session->setFlash(_('Your comment could not be saved') ,'error');
            }
        }
        
        //Build a user profile for use in the elements. The view must recive an array of $userProfile
        $userProfile['Person'] = $post['CreatedPerson'];
        $userProfile['Profile'] = $post['CreatedPerson']['Profile'];
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
