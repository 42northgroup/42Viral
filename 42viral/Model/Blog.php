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

App::uses('AppModel', 'Model');
App::uses('Content', 'Model');
/**
 * Manaages the Content object from the POV of a blog
 * 
 * @package app
 * @subpackage app.core
 * 
 * @author Jason D Snider <jason.snider@42viral.org>
 */
class Blog extends Content
{
    
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'Blog';
    
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
            'conditions' => array('Blog.status'=>array('archieved', 'published'))
        ),
        'admin_nothing'=>array('contain'=>array()),        
        'nothing'=>array(
            'contain'=>array(),
            'conditions' => array('Blog.status'=>array('archieved', 'published'))
        ),
        'public'=>array(
            'contain'=>array(
                'Tag'=>array()
            ),
            'conditions' => array('Blog.status'=>array('archieved', 'published'))
        ),
        'sitemap'=>array(
            'conditions' => array(
                'Blog.status'=>array(
                    'archieved', 
                    'published'
                )
            ),
            'contain'=>array(
                'Sitemap'
            ),
            'fields' => array(
                'Blog.canonical',
                'Blog.modified',
                'Sitemap.changefreq',
                'Sitemap.priority'
            )
        ),
        'standard'=>array(
            'CreatedPerson'=>array(
                'Profile'=>array()
            ),
            'Post'=>array(
                'conditions'=>array('Blog.status'=>'published'), 
                'order'=>array('Blog.created DESC')
            )
        )
    );

    /**
     * 
     * @var array
     * @access public
     */
    public $hasMany = array(
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'parent_content_id',
            'dependent' => true
        )
    );
    
    /**
     * 
     * @var array
     * @access public
     */
    public $belongsTo = array(
        'CreatedPerson' => array(
            'className' => 'Person',
            'foreignKey' => 'created_person_id',
            'dependent' => true
        )
    );
    
    /**
     * 
     * @var array
     * @access public
     */
    public $validate = array(
        
        'title' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' =>"Please enter a title",
                'last' => true
            ),
        ),
        'slug' => array(
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' =>"There is a problem with the slug",
                'last' => true                
            )
        ),
        
        'status' => array(
            'publishable' => array(
                'rule' => 'publishable',
                'message' =>"This blog is not ready to be published",
                'last' => true
            )
        )
        
    );
    
    public function __construct($id=false, $table=null, $ds=null) {
        parent::__construct($id, $table, $ds);
        $this->virtualFields = array(
            'url' => "CONCAT('/blog/',`{$this->alias}`.`slug`)"
        );
    }    
    
   /**
     * 
     * @access public
     */
    public function beforeSave()
    {             
        $this->data['Blog']['object_type'] = 'blog';
        return true;
    }  
    
    /**
     * Inject all "finds" against the Blog object with lead filtering criteria
     * @param array $query
     * @return type 
     * @access public
     */
    public function beforeFind($queryData) {
        parent::beforeFind($queryData);
        
        $queryData['conditions'] =!empty($queryData['conditions'])?$queryData['conditions']:array();
        $blogFilter = array('Blog.object_type' =>'blog');
        $queryData['conditions'] = array_merge($queryData['conditions'], $blogFilter);
        
        return $queryData;
    } 
    
    /**
     *
     * @param string $token
     * @param array $with
     * @param string $status
     * @return array
     * @access public
     */
    function fetchBlogWith($token, $with = 'public'){
            
        $theToken = array(
            'conditions'=>array('or' => array(
                'Blog.id' => $token,
                'Blog.slug' => $token, 
                'Blog.short_cut' => $token
            ))
        );      
            
        $finder = array_merge($this->dataSet[$with], $theToken);        
        $blog = $this->find('first', $finder);

        return $blog;
    }
    
    /**
     *
     * @param array $with
     * @param status $status
     * @return array
     * @access public
     */
    public function fetchBlogsWith($with = 'public'){
        $finder = $this->dataSet[$with];        
        $blog = $this->find('all', $finder);
        return $blog;
    }    
}