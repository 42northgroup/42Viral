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
App::uses('ContentAbstract', 'Model');
App::uses('Scrub', 'Lib');

/**
 * Manaages the Content object from the POV of a blog
 * 
 * @package app
 * @subpackage app.core
 * 
 * @author Jason D Snider <jsnider77@gmail.com>
 */
abstract class BlogAbstract extends ContentAbstract
{
    
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'Blog';
    
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
        ),
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
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' =>"There is a problem with the slug",
                'last' => true                
            )
        ),
        
        'status' => array(
            'publishable' => array(
                'rule' => 'publishable',
                'message' =>"Your blog is not ready to be published",
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
     * @author Jason D Snider <jsnider@jsnider77@gmail.com> 
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
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function beforeFind(&$query) 
    {
        $query['conditions'] =!empty($query['conditions'])?$query['conditions']:array();
        $blogFilter = array('Blog.object_type' =>'blog');
        $query['conditions'] = array_merge($query['conditions'], $blogFilter);
        return true;
    } 
    
    function fetchPublished($slug){
        
        $blog = $this->find('first', 
                array(  'conditions'=>array('Blog.slug' => $slug, 'Blog.status'=>'published'), 
                        'contain'=>array(
                            'Post'=>array('conditions'=>array('Post.status'=>'published'), 
                                'order'=>array('Post.created DESC')),
                        )
                    )
                );
        
        return $blog;
    }
}