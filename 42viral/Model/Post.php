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
 * Mangages the person object from the POV of a Lead
 * 
 * @package app
 * @subpackage app.core
 * 
 * @author Jason D Snider <jason.snider@42viral.org>
 */
class Post extends Content
{
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'Post';
        
    /**
    * Predefined data sets
    * @var array
    * @access public 
    */
    public $dataSet = array(
        'nothing'=>array(
            'contain'=>array()
        ),

        'created_person' => array(
            'contain' =>    array(
                'CreatedPerson'=>array(
                    'Profile'=>array()
                )
            ),
            'conditions' => array()
        ),

        'standard' => array(
            'contain' =>    array(
                'Conversation'=>array(
                    'CreatedPerson'=>array(
                        'Profile'=>array()
                    )
                ),
                'CreatedPerson'=>array(
                    'Profile'=>array()
                )
            ),
            'conditions' => array()
        ),

        'for_edit' => array(
            'contain' => array(
                'CreatedPerson' => array(
                    'Profile' => array()
                ),
                'Tag'
            ),
            'conditions' => array()
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
        ),
        'slug' => array(
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' =>"There is a problem with the slug",
                'last' => true                
            )
        ),
        'parent_content_id' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' =>"You need to have a blog attached",
                'last' => true
            ),            
        )
    );
    
   /**
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
     * @access public
     */
    public function beforeFind($queryData) {
        parent::beforeFind($queryData);

        $queryData['conditions'] =!empty($queryData['conditions'])?$queryData['conditions']:array();
        $postFilter = array('Post.object_type' =>'post');
        $queryData['conditions'] = array_merge($queryData['conditions'], $postFilter);
        
        return $queryData;
    }

    /**
     *
     * @param string $token
     * @param string|array $with
     * @param string|array $status
     * @return array 
     */    
    public function getPostWith($token, $with = null){

        $theToken = array(
            'or' => array(
                'Post.id' => $token, 
                'Post.slug' => $token, 
                'Post.short_cut' => $token
            )
        );
        
        $finder = array_merge($this->dataSet[$with], $theToken);
        
        $post = $this->find('first', $finder);

        return $post;
    }    
}