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

/**
 * Mangages the person object from the POV of a Lead
 * 
 * @package app
 * @subpackage app.core
 * 
 **** @author Jason D Snider <jason.snider@42viral.org>
 */
class PostAbstract extends ContentAbstract
{
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'Post';
    
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
        ),
    );    
    
    /**
     * 
     * @var array
     * @access public
     */
    public $hasMany = array(
        'Conversation' => array(
            'className' => 'Conversation',
            'foreignKey' => 'content_id',
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
            ),
            'parent_content_id' => array(
                'rule' => 'notEmpty',
                'message' =>"You need to have a blog attached",
                'last' => true
            ),            
        )
    );
    
   /**
     * @author Jason D Snider <jason.snider@42viral.org>
     * @access public
     */
    public function beforeSave()
    {        
        parent::beforeSave();
        $this->data['Post']['object_type'] = 'post';
        return true;
    }  
    
    /**
     * Inject all "finds" against the Post object with lead filtering criteria
     * @param array $query
     * @return type 
     * @author Jason D Snider <jason.snider@42viral.org>
     * @access public
     */
    public function beforeFind(&$query) 
    {
        $query['conditions'] =!empty($query['conditions'])?$query['conditions']:array();
        $postFilter = array('Post.object_type' =>'post');
        $query['conditions'] = array_merge($query['conditions'], $postFilter);
        return true;
    }

    /**
     *
     * @param type $token
     * @param type $with
     * @param type $status
     * @return array 
     */    
    public function fetchPostWith($token, $with = null, $status = 'published'){
        
        //Allows predefined data associations in the form of containable arrays
        if(!is_array($with)){
            
            switch(strtolower($with)){
                case 'standard':
                    $with = array(
                        'Conversation'=>array(),
                        'CreatedPerson'=>array()
                    );
                break;  
            
                case 'created_person':
                    $with = array(
                        'CreatedPerson'=>array()
                    );
                break;  
            
                default:
                    $with = array();
                break;
            }
  
        }

        $post = $this->find('first', 
                array(  
                    'conditions'=>array(
                        'or'=>array(
                            'Post.id' => $token, 
                            'Post.slug' => $token, 
                            'Post.short_cut' => $token
                        ), 
                        'Post.status'=>$status
                    ), 
                    
                    'contain' => $with,

                    )
                );

        return $post;
    }    
}