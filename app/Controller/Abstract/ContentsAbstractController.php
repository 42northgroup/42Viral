<?php

App::uses('AppController', 'Controller');

/**
 *
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
    public $uses = array('Blog', 'Content', 'Page', 'Post');
    
    /**
     * @var array
     * @access public
     */
    public $helpers = array('Member');
    
    /**
     * @return void
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
    
    }

    /* === Blog Management ========================================================================================== */
    
    /**
     * A index of all blogs
     * 
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
     */
    public function blogs(){
        $blogs = $this->Blog->find('all');
        $this->set('blogs', $blogs);
    }    
    
    /**
     * Removes a blog and all related posts
     * 
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
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
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
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
    }
    
    /**
     * Creates a blog - a blog contains a collection of posts
     * 
     * @param string $id
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
     */
    public function blog_edit($id)
    {
        
        if(!empty($this->data)){
            
            if($this->Blog->save($this->data)){
                $this->Session->setFlash(__('Your blog has been created'), 'success');
            }else{
                $this->Session->setFlash(__('There was a problem creating your blog'), 'error');
            }
        }
        
        $this->data = $this->Blog->findById($id);

        $this->set('statuses', $this->Blog->picklist('Status'));
    }    
    
    /**
     * Removes a post
     * 
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
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
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
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
                    $this->redirect("/Contents/post_edit/{$this->Post->id}");
                }else{
                    $this->Session->setFlash(__('There was a problem posting to your blog'), 'error');
                }

            }     
            
        }
    }
    
    /**
     * Creates a post or blog entry
     * 
     * @param string $id
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
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
        
        $this->data = $this->Post->findById($id);
        
        $this->set('statuses', $this->Post->picklist('Status'));
    }
    
    /**
     * Removes a web page
     * 
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
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
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
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
    }
 
    
    /**
     * Updates a web page
     * 
     * @param string $id
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
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
        
        $this->set('statuses', $this->Page->picklist('Status'));
    }    
    
    /**
     * Displays a list of all content created by a single user
     *
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
     */
    public function content() {
        
        $contents = $this->Content->find('all', 
                array(
                    'conditions'=>array(
                        'Content.created_person_id' => $this->Session->read('Auth.User.User.id')
                )));
                
        $this->set('contents', $contents);
        
    }   
    
}
