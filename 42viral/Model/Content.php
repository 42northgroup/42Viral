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
 * 
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('AppModel', 'Model');

/**
 * The parent class for content objects i.e. Page, Blog, Post etc.
 * @package content
 * @author Jason D Snider <jason.snider@42viral.org>
 */
class Content extends AppModel
{
    
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'Content';

    /**
     * Predefined data sets
     * @var array
     * @access public 
     */
    public $dataSet = array(

        'admin'=>array(
            'contain'=>array(
                'Tag'=>array()
            ),
            'conditions' => array('Page.status'=>array('archieved', 'published'))
        ),
        'admin_nothing'=>array('contain'=>array()),        
        'nothing'=>array(
            'contain'=>array(),
            'conditions' => array('Page.status'=>array('archieved', 'published'))
        ),
        'public'=>array(
            'contain'=>array(
                'Tag'=>array()
            ),
            'conditions' => array('Page.status'=>array('archieved', 'published'))
        ),
        'sitemap'=>array(
            'conditions' => array(
                'Page.status'=>array(
                    'archieved', 
                    'published'
                )
            ),
            'contain'=>array(
                'Sitemap'
            ),
            'fields' => array(
                'Content.canonical',
                'Content.modified',
                'Sitemap.changefreq',
                'Sitemap.priority'
            )
        )
    );

    /**
     *
     * @var string
     * @access public
     */
    public $useTable = 'contents';
    
    /**
     *
     * @var array
     */
    public $actsAs = array(
        
        'AuditLog.Auditable',
        
        'Random' => array(
            'Fields'=>array('short_cut')
        ),
        
        'ContentFilters.Scrubable'=>array(
            'Filters'=>array(
                'trim'=>'*',
                'htmlMedia'=>array('body'),
                'noHTML'=>array('id', 'tease', 'title', 'description', 'keywords', 'canonical', 'syntax', 'short_cut'),
            )
        ),
        
        'Search.Searchable',
        
        'Seo.Seo',
        
        'Tags.Taggable'

    );
    
    /**
     * 
     * @var array
     * @access public
     */
    public $hasOne = array(
        'Sitemap' => array(
            'className' => 'Seo.Sitemap',
            'foreignKey' => 'model_id',
            'conditions' => array(
                'Sitemap.model LIKE "Content"'
            ),
            'dependent' => true
        )
    );
    
    /**
     * Sets up the searchable behavior
     * @var array
     * @access public
     * @see https://github.com/CakeDC/search
     */
    public $filterArgs = array(
        array('name' => 'status', 'type' => 'value'),
        array('name' => 'object_type', 'type' => 'value'),
        array('name' => 'title', 'type' => 'like', 'field' => 'Content.title'),
        array('name' => 'body', 'type' => 'like', 'field' => 'Content.body'),
        array('name' => 'tags', 'type' => 'subquery', 'method' => 'findByTags', 'field' => 'Content.id'),
        array('name' => 'filter', 'type' => 'query', 'method' => 'orConditions')
    );    
    
    /**
     * @access public
     */
    public function __construct($id = false, $table = null, $ds = null) 
    { 
        parent::__construct($id, $table, $ds);
        
        $this->virtualFields = array(
            'url'=>"CONCAT('/',`{$this->alias}`.`object_type`,'/',`{$this->alias}`.`slug`)",
            'edit_url'=>"CONCAT('/admin','/',`{$this->alias}`.`object_type`,'s/','edit/',`{$this->alias}`.`id`)",
            'delete_url'=>"CONCAT('/admin','/',`{$this->alias}`.`object_type`,'s/','delete/',`{$this->alias}`.`id`)",
        );        
    }
    
    /**
     * A subquery for finding associated tags
     * @param array $data
     * @return array
     * @access public
     * @see https://github.com/CakeDC/search
     */
    public function findByTags($data = array()) {
        $this->Tagged->Behaviors->attach('Containable', array('autoFields' => false));
        $this->Tagged->Behaviors->attach('Search.Searchable');
        $query = $this->Tagged->getQuery('all', array(
            'conditions' => array('Tag.name'  => $data['tags']),
            'fields' => array('foreign_key'),
            'contain' => array('Tag')
        ));
        return $query;
    }
    
    /**
     * A query for or searches
     * @param array $data
     * @return array
     * @access public
     * @see https://github.com/CakeDC/search
     */
    public function orConditions($data = array()) {
        $filter = $data['filter'];
        $cond = array(
            'OR' => array(
                $this->alias . '.title LIKE' => '%' . $filter . '%',
                $this->alias . '.body LIKE' => '%' . $filter . '%',
            ));
        return $cond;
    }
    
    /**
     * Returns true if the blog is ready to be published
     * @return boolean 
     * @access public
     */
    public function publishable(){
       
        $error = 0;
        
        if($this->data[$this->alias]['status'] != 'draft'){
            if (strlen($this->data[$this->alias]['title']) == 0){
                $error++;
            }

            if (strlen($this->data[$this->alias]['body']) < 10) {
                $error++;
            }        

            if (strlen($this->data[$this->alias]['tease']) < 10) {
                $error++;
            }  
        }
        
        if($error == 0){
            return true;
        }else{
            return false;
        }
        
    }
    
    /**
     * Returns all content based on predefined conditions
     * @param array $with
     * @return array
     * @access public
     */
    function fetchContentWith($with = 'public'){
          
        $finder = $this->dataSet[$with];        
        $contents = $this->find('first', $finder);
        $this->set('contents', $contents);
    }
}