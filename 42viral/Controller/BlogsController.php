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
        $this->prepareDocUpload('Blog');
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
            
            $profile = $this->Person->getPersonWith($username, 'blog');
            
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
     * Removes a blog and all related posts
     * 
     * @return void
     * @access public
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
     * @return void
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
     * @return void
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
