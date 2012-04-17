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
 * @package 42viral\Content
 */

App::uses('AppModel', 'Model');
App::uses('Utility', 'Lib');
/**
 * The parent class for content objects i.e. Page, Blog, Post etc.
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral\Content
 */
class Content extends AppModel
{
    
    /**
     * The static name of the model
     * @access public
     * @var string
     */
    public $name = 'Content';

    /**
     * Specifies the table to be used by the Content model and it children
     * @access public
     * @var string
     */
    public $useTable = 'contents';
    
    /**
     * Predefined data sets
     * @var array
     * @access public 
     */
    public $dataSet = array(

        'admin'=>array(
            'contain'=>array(
                'Tag'=>array()
            )
        ),
        
        'admin_nothing'=>array('contain'=>array()),   
        
        'mine'=>array(
            'contain'=>array(
                'Tag'=>array()
            )
        ),
        
        'nothing'=>array(
            'contain'=>array(),
            'conditions' => array('Content.status'=>array('archived', 'published'))

        ),
        
        'public'=>array(
            'contain'=>array(
                'Tag'=>array()
            ),
            'conditions' => array('Content.status'=>array('archived', 'published'))
        ),
        
        'sitemap'=>array(
            'conditions' => array(
                'Content.status'=>array(
                    'archived', 
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
     * Defines the default set of behaivors for all content.
     * @access public
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
     * Defines the default has one data associations for all content
     * @access public
     * @var array
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
     * @access public
     * @var array
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
     * Initialisation for all new instances of Content
     * @access public
     * @param mixed $id Set this ID for this model on startup, can also be an array of options, see above.
     * @param string $table Name of database table to use.
     * @param string $ds DataSource connection name.
     * @return void
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
     * @access public
     * @param array $data
     * @return array
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
     * @access public
     * @param array $data
     * @return array
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
     * Returns all content based on predefined conditions
     * @access public
     * @param array $with
     * @param string $token
     * @return array
     */
    function fetchContentsWith($with = 'public', $token = null){
        
        //Used for variable injection
        switch('mine'){
            case 'mine':
                $theToken = array('Content.created_person_id' => $token);
                $finder = array_merge($this->dataSet[$with], $theToken);
            break;    
            
            default:  
                $finder = $this->dataSet[$with]; 
            break;
        }
        
               
        $content = $this->find('all', $finder);
        return $content;
    }
    
    /**
     * Parses text as markdown and converts it to HTML
     * @access public
     * @param string $text
     * @return string
     */
    public function markdown($text){
        return  Utility::markdown($text);  
    }    
}