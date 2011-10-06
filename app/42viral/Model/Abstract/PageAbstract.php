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
 * @author Jason D Snider <jason.snider@42viral.org>
 */
class PageAbstract extends ContentAbstract
{
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'Page';
    
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
        )
    );
    
    /**
     * @access public
     */
    public function __construct() 
    {
        parent::__construct();
       
    }
    
   /**
     * @author Jason D Snider <jason.snider@42viral.org>
     * @access public
     */
    public function beforeSave()
    {        
        parent::beforeSave();
        $model->data['Page']['object_type'] = 'page';
        return true;
    }    
    
    /**
     * Inject all "finds" against the Page object with lead filtering criteria
     * @param array $query
     * @return type 
     * @author Jason D Snider <jason.snider@42viral.org>
     * @access public
     */
    public function beforeFind(&$query) 
    {
        $query['conditions'] =!empty($query['conditions'])?$query['conditions']:array();
        $pageFilter = array('Page.object_type' =>'page');
        $query['conditions'] = array_merge($query['conditions'], $pageFilter);
        return true;
    }

    /**
     *
     * @param type $token
     * @param type $with
     * @param type $status
     * @return array 
     */    
    public function fetchPageWith($token, $with = null, $status = 'published'){
        
        //Allows predefined data associations in the form of containable arrays
        if(!is_array($with)){
            
            switch(strtolower($with)){

                default:
                    $with = array('Tag'=>array());
                break;
            }
  
        }

        $post = $this->find('first', 
                array(  
                    'conditions'=>array(
                        'or'=>array(
                            'Page.slug' => $token, 
                            'Page.short_cut' => $token
                        ), 
                        'Page.status'=>$status
                    ), 
                    
                    'contain' => $with,

                    )
                );

        return $post;
    }  
}