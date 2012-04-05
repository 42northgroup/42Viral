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
App::uses('Content', 'Model');

/**
 * Mangages the person object from the POV of a Lead
 * 
 * @package app
 * @subpackage app.core
 * 
 * @author Jason D Snider <jason.snider@42viral.org>
 */
class Page extends Content
{
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'Page';

    /**
     * Predefined data sets
     * @var array
     * @access public 
     */
    public $dataSet = array(

        'edit' => array(
            'contain' =>    array(
                'Tag'=>array(),
                'Sitemap'=>array()
            ),
            'conditions'=>array()
        ),
        'nothing'=>array(
            'contain'=>array(),
            'conditions' => array()
        ),
        'public'=>array(
            'contain'=>array(
                'Tag'=>array()
            ),
            'conditions' => array('Page.status'=>array('archieved', 'published'))
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
                'message' =>"This page is not ready to be published",
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
     * @access public
     */
    public function beforeFind($queryData) {
        parent::beforeFind($queryData);
        
        $queryData['conditions'] =!empty($queryData['conditions'])?$queryData['conditions']:array();
        $pageFilter = array('Page.object_type' =>'page');
        $queryData['conditions'] = array_merge($queryData['conditions'], $pageFilter);

        return $queryData;
    }

    /**
     * Returns a given page based on a given token and a with(query) array
     * @param type $token
     * @param type $with
     * @param type $status
     * @return array 
     */    
    public function getPageWith($token, $with = 'public'){
            
        $theToken = array(
            'conditions'=>array('or' => array(
                'Page.id' => $token,
                'Page.slug' => $token, 
                'Page.short_cut' => $token
            ))
        );      
            
        $finder = array_merge($this->dataSet[$with], $theToken);        
        $page = $this->find('first', $finder);

        return $page;
    } 
    
    /**
     * Returns a given page based predefinded conditions
     * @param type $token
     * @param type $with
     * @param type $status
     * @return array 
     */    
    public function fetchPagesWith($with = 'public'){
        $finder = $this->dataSet[$with];        
        $pages = $this->find('all', $finder);
        return $pages;
    }      
}