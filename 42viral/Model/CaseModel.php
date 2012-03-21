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

/**
 * Mangages the person object
 * 
 * @package app
 * @subpackage app.core
 * 
 * @author Jason D Snider <jason.snider@42viral.org>
 */
class CaseModel extends AppModel
{
    
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'CaseModel';
    
    /**
     *
     * @var string
     * @access public
     */
    public $useTable = 'cases';
    
    /**
     *
     * @var array
     */
    public $actsAs = array(
        /*
        'Picklist' => array(
            
            'ObjectTypes'=>array(
                'ticket'=>'Ticket'
            ),
        
            'Status'=>array(
                'new'=>'New',
                'closed'=>'Closed'
            )
            
        ),
        */
        'ContentFilters.Scrubable'=>array(
            'Filters'=>array(
                'trim'=>'*',
                'htmlStrict'=>array('body'),
                'noHTML'=>array('id', 'subject', 'status', 'object_type'),
            )
        ),
        
        'Random'=>array(
            'Fields'=>array(
                'case_number'
            )
        )
    );
    
    /**
     *
     * @var array
     * @access public 
     */
    public $belongsTo = array(
        'Person' => array(
            'foreignKey' => 'model_id',

            'conditions' => array(
                'CaseModel.model' => 'Person'
            ),

            'dependent' => true
        )
    );
    
    /**
     * @access public
     */
    public function __construct($id = false, $table = null, $ds = null) 
    { 
        parent::__construct($id, $table, $ds);
        
        $this->virtualFields = array(
            'url'=>"CONCAT('/admin/',`{$this->alias}`.`object_type`,'s/view/',`{$this->alias}`.`id`)"
        );        
    }  
      
   /**
    * Returns a single case with the specified associated data. 
    * NOTE: When using the by clause please understand, this MUST be a unique index in the profiles table
    * 
    * @param string $id - An id for retreving records
    * @param string|array $with
    * @param string $by - This will usally be id, but sometimes we want to use something else
    * @return array
    * @access public
    */
    public function fetchCaseWith($id, $with = array(), $by = 'id')
    {
        //Allows predefined data associations in the form of containable arrays
        if(!is_array($with)){

            switch(strtolower($with)){
                default:
                    $with = array('Person'=>array());
                break;
            }
        }

        //Go fetch the profile
        $case = $this->find('first', array(
           'contain' => $with,
           'conditions' => array(
               "CaseModel.{$by}"  => $id
           )
        ));
               
        return $case;        
    }
    
}