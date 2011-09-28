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
 * @author Jason D Snider <jason.snider@42viral.org>
 */
class BlogAbstract extends ContentAbstract
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
    public function beforeFind(&$query) 
    {
        $query['conditions'] =!empty($query['conditions'])?$query['conditions']:array();
        $blogFilter = array('Blog.object_type' =>'blog');
        $query['conditions'] = array_merge($query['conditions'], $blogFilter);
        return true;
    } 
    
    /**
     *
     * @param type $token
     * @param type $with
     * @param type $status
     * @return array
     */
    function fetchBlogWith($token, $with = null, $status = 'published'){
        
        //Allows predefined data associations in the form of containable arrays
        if(!is_array($with)){
            
            switch(strtolower($with)){
                case 'standard':
                    $with = array(
<<<<<<< HEAD

=======
>>>>>>> Implementation of new naivigation
                        'CreatedPerson'=>array('Profile'=>array()),
                        'Post'=>array('conditions'=>array('Post.status'=>'published'), 
                            'order'=>array('Post.created DESC'))
                    );
                break;   
            
                default:
                    $with = array();
                break;
            }
  
        }
        
        $blog = $this->find('first', 
                array(  'conditions'=>array(
                        'or'=>array(
                            'Blog.slug' => $token,
                            'Blog.short_cut' => $token
                        ), 
                        'Blog.status'=>$status), 
                        'contain'=>$with
                    )
                );
        
        return $blog;
    }
}