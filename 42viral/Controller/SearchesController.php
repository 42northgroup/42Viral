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
 * Provides controll logic for managing search actions
 *
 * @author Jason D Snider <jason.snider@42viral.org>
 */
 class SearchesController extends AppController {

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
    public $uses = array('Content', 'Page', 'PicklistManager.Picklist', 'Tags.Tagged');
    
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
     * Simple search, converts post data to named params then performs a self redirect to load the named params 
     * creating a bookmarkable search results page. 
     * @return void
     * @access public
     */
    public function index() {
        
        $q = '';
        $display = 'none';

        if(!empty($this->data)){
            $q = $this->data['Content']['q'];
            $this->redirect("/searches/index/q:{$q}");
        }elseif(!empty($this->params['named'])){
            
            $conditions = array(
                'title'=>$this->request->params['named']['q'], 
                'body'=>$this->request->params['named']['q'],
            );           
            
            //Predefined object types and statuses
            $this->request->params['named']['status'] = 'published';
            $this->request->params['named']['object_type'] = 'blog page post'; 
            $conditions['status'] = explode(' ', $this->request->params['named']['status']);
            $conditions['object_type'] = explode(' ', $this->request->params['named']['object_type']);
            
            $criteria = $this->Content->parseCriteria($conditions);
            
            
            
            $this->paginate = array(
                'conditions' => $this->Content->parseCriteria($conditions),
                'limit' => 10
            );

            $data = $this->paginate('Content');
            
            $this->set(compact('data'));   
            
            $this->request->data['Content']['q'] = $this->params['named']['q'];
            $display = 'results';
        }
        
            
        $this->set('display', $display);
        $this->set('title_for_layout', 'Search');
        
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
            
        }else{
            
            //Precheck the most likely boxes, the user can adjust from there
            $this->request->data['Content'] = 
                array('status' => array
                (
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
        
        $this->set('statuses', 
        $this->Picklist->fetchPicklistOptions(
                'publication_status', array('emptyOption'=>false, 'otherOption'=>false)));
        
        $this->set('objectTypes', 
        $this->Picklist->fetchPicklistOptions(
                'object_type', array('categoryFilter' => 'Content',  'emptyOption'=>false, 'otherOption'=>false)));
            
        $this->set('display', $display);
        
        $this->set('title_for_layout', 'Advanced Search');
        
    }
}
