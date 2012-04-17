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
 * @package       42viral\app
 */

App::uses('AppModel', 'Model');
/** 
 * Manages presons' details table
 * @package app
 * @subpackage app.core
 * 
 * @author Lyubomir R Dimov <lrdimov@yahoo.com>
 */
class PersonDetail extends AppModel
{
    /**
     * Model name
     * 
     * @var string
     * @access public
     */
    public $name = 'PersonDetail';    
    
    /**
     * Table name
     * @var string
     * @access public
     */
    public $useTable = 'person_details';
    
    /**
     * Behaviors
     * @var array
     */
    public $actsAs = array(
        'Log'
    );
    
    /**
     * Contact data types
     * @var array
     * @access public
     */
    public $types = array(
        'email' => 'Email',
        'phone' => 'Phone'
    );
    
    /**
     * belongsTo
     * @var array
     * @access public
     */
    public $belongsTo = array(
        'Person' => array(
            'className' => 'Person',
            'foreignKey' => 'person_id',
            'dependent' => false
        )
    );
    
    /**
     * Field to validate on save
     * @var array
     * @access public
     */
    public $validate = array(
        'type' => array(
            'rule'    => array('notEmpty'),
            'message' => 'Type field can not be empty'
        ),
        'value' => array(
            'validateEntry' => array(
                'rule'    => array('validateEntry'),
                'message' => 'Information entered in the Enrty filed does not correspond to the Type'
            ),
            
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Entry field can not be empty'
            )
        ),
        'category' => array(
            'rule'    => array('notEmpty'),
            'message' => 'Category field can not be empty'
        )
    );
    
    /**
     * Returns true if the user has submitted the same password twice.
     * @return boolean
     * @author Jason D Snider <jsnider@microtain.net>
     * @access public
     */
    public function validateEntry()
    {
        $valid = false;
        
        if($this->data[$this->alias]['type'] == 'email') {
            
            return Validation::email($this->data[$this->alias]['value']);
        }elseif($this->data[$this->alias]['type'] == 'phone'){
            
            return Validation::phone($this->data[$this->alias]['value']);
        }
    }
    
    /**
     * Fetches a person's phones and emails and combines them in 1 array which is then returned
     *
     * @param string $personId
     * @return array
     */
    public function allDetails($personId)
    {
        $person_emails = $this->find('all', array(
            'conditions' => array(
                'PersonDetail.person_id' => $personId,
                'PersonDetail.type' => 'email'
            ),
            'contain' => array()
        ));
        
        $person_phones = $this->find('all', array(
            'conditions' => array(
                'PersonDetail.person_id' => $personId,
                'PersonDetail.type' => 'phone'
            ),
            'contain' => array()
        ));
        
        $person_details['emails'] = $person_emails;
        $person_details['phones'] = $person_phones;
        
        return $person_details;
    }
}