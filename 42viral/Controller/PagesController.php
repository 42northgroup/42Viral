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
        
        $this->auth(array('*'));
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
     * Displays a list of blogs
     *
     * @param array
     */
    public function index() {
        
        $pages = $this->Page->fetchPagesWith();
        
        $this->set('pages', $pages);
        $this->set('title_for_layout', 'Pages');
    } 
    
    /**
     * Displays a blog post
     *
     * @param array
     */
    public function view($slug) {

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
     * Displays a list of blogs
     *
     * @param array
     */
    public function admin_index() {
        
        $pages = $this->Page->fetchPagesWith('admin_standard');
        
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

            if($this->Page->saveAll($this->data)){
                $this->Session->setFlash(__('Your page has been updated'), 'success');
            }else{
                $this->Session->setFlash(__('There was a problem updating your page'), 'error');
            }
        }
        
        $this->data = $this->Page->fetchPageWith($id, 'edit');
        
        
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