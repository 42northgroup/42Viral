<?php

App::uses('AppController', 'Controller');

/**
 *
 */
abstract class SearchesAbstractController extends AppController {

    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Searches';

    /**
     * Default helper
     *
     * @var array
     * @access public
     */
    public $helpers = array('Tags.TagCloud');

    /**
     * This controller does not use a model
     *
     * @var array
     * @access public
     */
    public $uses = array('Content', 'Page', 'Picklist', 'Tags.Tagged');
    
    /**
     * Works with the searchable behavior
     * @var array
     * @access public
     */
    public $presetVars = array(
        array('field' => 'title', 'type' => 'value'),
        array('field' => 'body', 'type' => 'value'),
        array('field' => 'status', 'type' => 'checkbox'),
        array('field' => 'object_type', 'type' => 'checkbox')
    );

    /**
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        
        $this->auth(array('*'));
    }

    /**
     * Advanced search, converts post data to named params then performs a self redirect to load the named params 
     * creating a bookmarkable search results page. 
     * @return void
     * @access public
     */
    public function advanced() {
        
        $display = 'none';
        
        if(!empty($this->data)){
            $q =''; //holds the final query string in the form of a Pretty URL
            foreach($this->data['Content'] as $key => $value){
                
                //Converts MUTLI option arrays to a string
                $a = '';
                
                //Parse the MUTLI option arrays
                if(is_array($value)){ 
                    $i=0;
                    foreach($value as $k => $v){
                        $a .= ($i == 0)?"$v":" $v";
                        $i++;
                    }
                    $q .= "{$key}:{$a}/";
                }else{
                    ///Parse the strings
                    $q .= "{$key}:{$value}/";
                }
            }
            
            //Redirect to the results page
            $this->redirect("/searches/advanced/{$q}");
            
        }elseif(!empty($this->params['named'])){

            //Match conditions
            $conditions = array(
                'title'=>$this->request->params['named']['title'], 
                'body'=>$this->request->params['named']['body'],
                'tags'=>$this->request->params['named']['tags']
            ); 
            
            //IN array conditions
            $conditions['status'] = explode(' ', $this->request->params['named']['status']);
            $conditions['object_type'] = explode(' ', $this->request->params['named']['object_type']);
            
            $this->paginate = array(
                'conditions' => $this->Content->parseCriteria($conditions),
                'limit' => 10
            );

            $data = $this->paginate('Content');
            
            $this->set(compact('data'));   
            
            $this->request->data['Content'] = $conditions;
            
            $display = 'results';
        }
        
        $this->set('statuses', 
        $this->Picklist->fetchPicklistOptions(
                'publication_status', array('emptyOption'=>false, 'otherOption'=>false)));
        
        $this->set('objectTypes', 
        $this->Picklist->fetchPicklistOptions(
                'object_type', array('categoryFilter' => 'Content',  'emptyOption'=>false, 'otherOption'=>false)));
            
        $this->set('display', $display);
        
        $this->set('Advanced Search');
        
        $this->set('title_for_layout', 'Advanced Search');
        
        if(empty($this->data)){
            $this->request->data['Search'] = 
                    array('status' => array
                    (
                        0 => 'draft',
                        1 => 'published'
                    ),
                    'object_type' => array
                    (
                        0 => 'blog',
                        1 => 'page',
                        2 => 'post'
                    ) 
                );
        }
    }
}
