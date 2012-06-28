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
 * @copyright     Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package       42viral\app
 */

App::uses('AppModel', 'Model');
/**
 */
class  PhoneNumber extends AppModel
{
    /**
     * Model name
     *
     * @var string
     * @access public
     */
    public $name = 'PhoneNumber';

    /**
     * Table name
     * @var string
     * @access public
     */
    public $useTable = 'phone_numbers';

    /**
     * Behaviors
     * @var array
     */
    public $actsAs = array(
        'Log',
        'Scrubable'=>array(
            'Filters'=>array(
                'trim'=>'*',
                'noHTML'=>array('*'),
                'phoneNumber'=>array('phone_number'),
            )
        ),
    );

    /**
     * belongsTo
     * @var array
     * @access public
     */
    public $belongsTo = array(
        'Person' => array(
            'className' => 'Person',
            'foreignKey' => 'model_id',
            'conditions'=>array('model'=>'Person'),
            'dependent' => false
        )
    );

    /**
     * Field to validate on save
     * @var array
     * @access public
     */
    public $validate = array(
        'access' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please choose who can view the phone number'
            )
        ),
        'type' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please choose a type for this phone number'
            )
        ),
        'label' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please create a label for this phone number'
            )
        ),
        'phone_number' => array(
            'phone_number' => array(
                'rule'    => array('phone', null, 'all'),
                'message' => 'Please enter a valid phone number'
            ),

            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter a phone number'
            )
        )
    );

    /**
     * Defines various types of email addresses
     *
     * @access private
     * @var array
     */
    private $__listPhoneNumberTypes = array(
        'cell'=>array(
            'label'=>'Cell',
            '_ref'=>'cell',
            '_inactive'=>false,
            'category'=>'',
            'tags'=>array()
        ),
        'home'=>array(
            'label'=>'Home',
            '_ref'=>'home',
            '_inactive'=>false,
            'category'=>'',
            'tags'=>array()
        ),
        'work'=>array(
            'label'=>'Work',
            '_ref'=>'cwork',
            '_inactive'=>false,
            'category'=>'',
            'tags'=>array()
        ),
        'other'=>array(
            'label'=>'Other',
            '_ref'=>'other',
            '_inactive'=>false,
            'category'=>'',
            'tags'=>array()
        ),
    );

    /**
     * Returns a key to value action types. This list can be flat, categorized or a partial list based on tags.
     * @access public
     * @param array $list
     * @param array $tags
     * @param string $catgory
     * @param boolean $categories
     * @return array
     */
    public function listPhoneNumberTypes($tags = null, $category = null, $categories = false){
        return $this->_listParser($this->__listPhoneNumberTypes, $tags, $category, $categories);
    }
}