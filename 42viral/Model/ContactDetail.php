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
 * Manages presons' details table
 * @package app
 * @subpackage app.core
 *
 * @author Lyubomir R Dimov <lrdimov@yahoo.com>
 */
class  ContactDetail extends AppModel
{
    /**
     * Model name
     *
     * @var string
     * @access public
     */
    public $name = 'ContactDetail';

    /**
     * Table name
     * @var string
     * @access public
     */
    public $useTable = 'contact_details';

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
    private $__types = array(
        'email' => array(
        	'label'=>'Email',
        	'category'=>'',
        	'tags'=>array(),
        ),
        'phone' => array(
        	'label'=>'Phone',
        	'category'=>'',
        	'tags'=>array(),
        ),
    );

    /**
     * Returns a key to value list of types. This list can be flat, categorized or a partial list based on tags.
     * @access public
     * @param string $country The country to which you are looking for a county lelvel unit
     * @param string $state The level unit of the country to which you are looking for country level units
     * @return array
     */
    public function listTypes($tags = null, $catgory = null, $categories = false){
    	$types = array();

    	foreach($this->__types as $key => $values){
    		if(empty($values['_inactive'])){
    			$types[$key] = $values['label'];
    		}
    	}

    	return $types;
    }

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
            'message' => 'You must choose a type'
        ),
        'value' => array(
            'validateEntry' => array(
                'rule'    => array('validateEntry'),
                'message' => 'Invalid format'
            ),

            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Entry field can not be empty'
            )
        ),
        'label' => array(
            'rule'    => array('notEmpty'),
            'message' => 'You must label the detail'
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
     * @access public
     * @param string $model
     * @param string $modelId
     * @return array
     */
    public function allDetails($model, $modelId)
    {
    	$details = array();

        $emails = $this->find('all', array(
            'conditions' => array(
            	'ContactDetail.model' => $model,
                'ContactDetail.model_id' => $modelId,
                'ContactDetail.type' => 'email'
            ),
            'contain' => array()
        ));

        $phones = $this->find('all', array(
            'conditions' => array(
            	'ContactDetail.model' => $model,
                'ContactDetail.model_id' => $modelId,
                'ContactDetail.type' => 'phone'
            ),
            'contain' => array()
        ));

        $details['emails'] = $person_emails;
        $details['phones'] = $person_phones;

        return $details;
    }
}