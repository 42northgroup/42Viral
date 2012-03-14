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
 * 
 * @package app
 * @subpackage app.core
 * 
 * @author Lyubomir R Dimov <lrdimov@yahoo.com>
 */
class PersonDetail extends AppModel
{
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'PersonDetail';    
    
    /**
     *
     * @var string
     * @access public
     */
    public $useTable = 'person_details';
    
    /**
     *
     * @var array
     */
    public $actsAs = array(
        'Log'
    );
    
    /**
     *
     * @var array
     * @access public
     */
    public $types = array(
        'email' => 'Email',
        'phone' => 'Phone'
    );
    
    /**
     *
     * @var array
     * @access public
     */
    public $hasOne = array(
        'Person' => array(
            'className' => 'Person',
            'foreignKey' => 'person_id',
            'dependent' => false
        )
    );
    
    /**
     *
     * @var array
     * @access public
     */
    public $validate = array(
        'type' => array(
            'rule'    => array('notEmpty'),
            'message' => 'Type field can not be empty'
        ),
        'value' => array(
            'rule'    => array('notEmpty'),
            'message' => 'Entry field can not be empty'
        ),
        'category' => array(
            'rule'    => array('notEmpty'),
            'message' => 'Category field can not be empty'
        )
    );
    
    /**
     * Fetches a person's phones and emails and combines them in 1 array which is then returned
     *
     * @param string $personId
     * @return array
     */
    public function fetchPersonDetails($personId)
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