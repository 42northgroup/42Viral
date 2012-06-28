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
class  EmailAddress extends AppModel
{
    /**
     * Model name
     *
     * @var string
     * @access public
     */
    public $name = 'EmailAddress';

    /**
     * Table name
     * @var string
     * @access public
     */
    public $useTable = 'email_addresses';

    /**
     * Behaviors
     * @var array
     */
    public $actsAs = array(
        'Log',
        'Scrubable'=>array(
            'Filters'=>array(
                'trim'=>'*',
                'noHTML'=>array('*')
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
        'type' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please choose aa type for the email address'
            )
        ),
        'label' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please create a label for the email address'
            )
        ),
        'email_address' => array(
            'email' => array(
                'rule'    => array('email', false),
                'message' => 'Please enter a valid email address'
            ),

            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter an email address'
            )
        )
    );

    /**
     * Defines various types of email addresses
     *
     * @access private
     * @var array
     */
    private $__listEmailAddressTypes = array(
        'personal'=>array(
            'label'=>'Personal',
            '_ref'=>'personal',
            '_inactive'=>false,
            'category'=>'',
            'tags'=>array()
        ),
        'business'=>array(
            'label'=>'Business',
            '_ref'=>'business',
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
    public function listEmailAddressTypes($tags = null, $category = null, $categories = false){
        return $this->_listParser($this->__listEmailAddressTypes, $tags, $category, $categories);
    }
}