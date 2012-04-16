<?php
/**
 * Manages content data with page specific parameters
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
 * @package 42viral\Content\Page
 */

App::uses('AppModel', 'Model');
App::uses('Content', 'Model');
/**
 * Manages content data with page specific parameters
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral\Content\Page
 */
class Page extends Content
{
    /**
     * The static name of the class
     * @access public
     * @var string
     */
    public $name = 'Page';

    /**
     * Predefined data sets
     * @access public
     * @var array 
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
     * Defines a page's model validation
     * @access public
     * @var array
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
        )
    );

   /**
    * Applies the proper object_type to the page data set prior to a save
    * @access public
    * @return boolean
    */
    public function beforeSave()
    {        
        parent::beforeSave();
        $this->data['Page']['object_type'] = 'page';
        return true;
    }    
    
    /**
     * Inject all "finds" against the Page object with lead filtering criteria
     * @access public
     * @param array $queryData
     * @return array
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
     * @access public
     * @param string $token
     * @param string $with
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
     * @access public
     * @param string $with
     * @return array 
     */    
    public function fetchPagesWith($with = 'public'){
        $finder = $this->dataSet[$with];        

        $pages = $this->find('all', $finder);
        return $pages;
    }     
}