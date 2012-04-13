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
class Documentation extends Content
{
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'Documentation';

    /**
     * Predefined data sets
     * @var array
     * @access public 
     */
    public $dataSet = array(
        'nothing'=>array(
            'contain'=>array(),
            'conditions' => array()
        ),
        'public'=>array(
            'contain'=>array(
                'Tag'=>array()
            )
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
        $this->data['Documentation']['object_type'] = 'Documentation';
        return true;
    }    
    
    /**
     * Inject all "finds" against the Documentation object with lead filtering criteria
     * @param array $query
     * @return type 
     * @access public
     */
    public function beforeFind($queryData) {
        parent::beforeFind($queryData);
        
        $queryData['conditions'] =!empty($queryData['conditions'])?$queryData['conditions']:array();
        $DocumentationFilter = array('Documentation.object_type' =>'Documentation');
        $queryData['conditions'] = array_merge($queryData['conditions'], $DocumentationFilter);

        return $queryData;
    }

    /**
     * Returns a given Documentation based on a given token and a with(query) array
     * @param type $token
     * @param type $with
     * @param type $status
     * @return array 
     */    
    public function getDocumentationWith($token, $with = 'public'){
            
        $theToken = array(
            'conditions'=>array('or' => array(
                'Documentation.id' => $token,
                'Documentation.slug' => $token, 
                'Documentation.short_cut' => $token
            ))
        );      
            
        $finder = array_merge($this->dataSet[$with], $theToken);        
        $Documentation = $this->find('first', $finder);

        return $Documentation;
    } 
    
    /**
     * Returns a given Documentation based predefinded conditions
     * @param string $token
     * @return array 
     */    
    public function fetchDocumentationsWith($with = 'public'){
        $finder = $this->dataSet[$with];        

        $Documentations = $this->find('all', $finder);
        return $Documentations;
    }     
}