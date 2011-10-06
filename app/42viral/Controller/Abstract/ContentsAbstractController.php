<?php
/**
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppController', 'Controller');
App::uses('Handy', 'Lib');
/**
 * @author Jason D Snider <jason.snider@42viral.org>
 */
abstract class ContentsAbstractController extends AppController {

    /**
     * Controller name
     * @var string
     * @access public
     */
    public $name = 'Contents';
    
    /**
     * This controller does not use a model
     * @var array
     * @access public
     */
    public $uses = array('Blog', 'Content', 'Conversation', 'Oauth', 'Page', 'Person', 'Picklist', 'Post');
    
    /**
     * @var array
     * @access public
     */
    public $components = array('File', 'Oauths');  
    
    /**
     * @var array
     * @access public
     */
    public $helpers = array('Member', 'Paginator');
    
    /**
     * @return void
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->auth();
    }
    
    
    /* === Blog Management ========================================================================================== */
    
    /**
     * A index of all blogs
     * 
     * @return void
     * @access public
     */
    public function blogs(){
        $blogs = $this->Blog->find('all');
        $this->set('blogs', $blogs);
        $this->set('title_for_layout', 'Blogs');
    }    
    
    /**
     * Removes a blog and all related posts
     * 
     * @return void
     * @access public
     */
    public function blog_delete($id){
        
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
     * @access public
     */
    public function blog_create()
    {
        
        if(!empty($this->data)){
            
            if($this->Blog->save($this->data)){
                $this->Session->setFlash(__('Your blog has been created'), 'success');
                $this->redirect("/Contents/blog_edit/{$this->Blog->id}");
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
     * @return void
     * @access public
     */
    public function blog_edit($id)
    {
        
        if(!empty($this->data)){
            
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
    
    /**
     * Removes a post
     * 
     * @return void
     * @access public
     */
    public function post_delete($id){

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
    public function post_create($blogId = null)
    {
        
        if(is_null($blogId)){

            $blogs = $this->Blog->find('all');
            $this->set('blogs', $blogs);
            
        }else{

            if(!empty($this->data)){

                if($this->Post->save($this->data)){
                    $this->Session->setFlash(__('You have successfully posted to your blog'), 'success');
                    $this->redirect("/contents/post_edit/{$this->Post->id}");
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
    public function post_edit($id)
    {
        if(!empty($this->data)){

            if($this->Post->save($this->data)){
                $this->Session->setFlash(__('You have successfully posted to your blog'), 'success');
            }else{
                $this->Session->setFlash(__('There was a problem posting to your blog'), 'error');
            }
        }  
        
        $this->data = $this->Post->fetchPostWith($id, 'created_person');
        
        
        $this->set('statuses', 
                $this->Picklist->fetchPicklistOptions(
                        'publication_status', array('emptyOption'=>false, 'otherOption'=>false)));

        $themePath = ROOT . DS . APP_DIR . DS . 'View' . DS . 'Themed' . DS 
                . Configure::write('Theme.set', 'Default') . DS;

        $unthemedPath = ROOT . DS . APP_DIR . DS . 'View' . DS;
        $relativeCustomPath = 'Blogs' . DS . 'Custom' . DS; 
        
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
     * An action for commenting on a blog post
     * @return void
     * @access public
     */
    public function post_comment(){
        if( $this->Session->check('Auth.post_url') ){
            $this->redirect($this->Session->read('Auth.post_url'));
        }
        
        if($this->data){            
            
            if($this->Conversation->save($this->data)){
                $this->Session->setFlash(_('Your comment has been saved') ,'success');
                $this->redirect($this->referer());
            }else{
                $this->Session->setFlash(_('Your comment could not be saved') ,'error');
                $this->redirect($this->referer());
            }
        }
        $this->set('title_for_layout', "Comment on a Blog Post");       
        
    }
    
    
    /**
     * Removes a web page
     * 
     * @return void
     * @access public
     */
    public function page_delete($id){

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
     * @access public
     */
    public function page_create()
    {

        if(!empty($this->data)){

            if($this->Page->save($this->data)){
                $this->Session->setFlash(__('Your page has been created'), 'success');
                $this->redirect("/Contents/page_edit/{$this->Page->id}");
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
    public function page_edit($id)
    {
        if(!empty($this->data)){

            if($this->Page->save($this->data)){
                $this->Session->setFlash(__('Your page has been updated'), 'success');
            }else{
                $this->Session->setFlash(__('There was a problem updating your page'), 'error');
            }
        }
        
        $this->data = $this->Page->findById($id);
        
        
        $this->set('statuses', 
                $this->Picklist->fetchPicklistOptions(
                        'publication_status', array('emptyOption'=>false, 'otherOption'=>false)));
     
        $this->set('title_for_layout', "Update {$page['Page']['title']}");        
    }    
    
    /**
     * Displays a list of all content created by a single user
     *
     * @return void
     * @access public
     */
    public function content($username) 
    {
        
        $mine = false;
        
        $person = $this->Person->fetchPersonWith($username, array('Profile', 'Content'));
        
        if($this->Session->check('Auth.User.id')){
            if($this->Session->read('Auth.User.username') == $username){
                $mine = true;
            }
        }
        
        $this->set('mine', $mine);
        $this->set('userProfile', $person);
        $this->set('title_for_layout', "Content Stream");        
    }  
    
    /**
     * An action for promoting new content
     *
     * @return void
     * @access public
     */
    public function promote($id, $redirect_url='users/social_media')
    {
        
        if( !$this->Session->check('Auth.User.sm_list') ){
            
            $sm_list = $this->Oauth->find('list', array(
                'conditions' => array('Oauth.person_id' => $this->Session->read('Auth.User.id')),
                'fields' => array('Oauth.oauth_id', 'Oauth.service')
            ));

            $this->Session->write('Auth.User.sm_list', $sm_list);
        }
        
        foreach( $this->Session->read('Auth.User.sm_list') as $key => $val ){
            switch ($val){
                
                case 'facebook':
                    $this->Oauths->check_session_for_token('facebook', $redirect_url);
                    break;
                
                case 'linked_in':
                    $this->Oauths->check_session_for_token('linked_in', $redirect_url);
                    break;
                case 'twitter':
                    $this->Oauths->check_session_for_token('twitter', $redirect_url);
                    break;
            }
        }
        
        $content = $this->Content->findById($id);
        $this->set('content', $content);
        
        $objectType = strtolower($content['Content']['object_type']);

        $shorty = " " . Configure::read("Shorty.{$objectType}") . $content['Content']['short_cut'];

        
        $twitter = Handy::truncate($content['Content']['tease'] , (140 - strlen($shorty))) . $shorty;

        $other = $content['Content']['tease'] . " " . Configure::read('Domain.url') . $content['Content']['url'];
        
        $promo = array(
            'twitter'=>$twitter,
            'other'=>$other
        );
        
        $this->set('promo', $promo);

        $this->set('title_for_layout', "Update {$post['Post']['name']}");
        
    }

}
