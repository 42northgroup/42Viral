<?php
/**
 * The parent model for all person related data
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
 * @package 42viral\Person
 */

App::uses('AppModel', 'Model');
/**
 * The parent model for all person related data
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral\Person
 */
class Person extends AppModel
{
    /**
     * The static name of the person model
     * @access public
     * @var string
     */
    public $name = 'Person';

    /**
     * Specifies the table used by the person object
     * @access public
     * @var string
     */
    public $useTable = 'people';

    /**
     * Specifies the behaviors invoked by the conversation model
     * @access public
     * @var array
     */
    public $actsAs = array(
        'AuditLog.Auditable',
        'Scrubable' => array(
            'Filters' => array(
                'trim' => '*',
                'safe' => '*'
            )
        )
    );

    /**
     * Defines the person model's has one relationships
     * @access
     * @var array
     */
    public $hasOne = array();

    /**
     * Defines the person model's has many relationships
     * @access
     * @var array
     */
    public $hasMany = array(

        'Address' => array(
            'className' => 'Address',
            'foreignKey' => 'model_id',
            'conditions' => array('Address.model' => 'Person'),
            'dependent' => true
        ),
        'EmailAddress' => array(
            'className' => 'EmailAddress',
            'foreignKey' => 'model_id',
            'conditions'=>array('model'=>'Person'),
            'dependent' => true
        ),
        'PhoneNumber' => array(
            'className' => 'PhoneNumber',
            'foreignKey' => 'model_id',
            'conditions'=>array('model'=>'Person'),
            'dependent' => true
        ),
        'SocialNetwork' => array(
            'className' => 'SocialNetwork',
            'foreignKey' => 'model_id',
            'conditions'=>array('model'=>'Person'),
            'dependent' => true
        )
    );

    /**
     * Controls who is allowed to post to a target blog
     * @access private
     * @var array
     */
    private $__listDisplayNames = array(
        'public'=>array(
            'label'=>'Public',
            '_ref'=>'public',
            '_inactive'=>false,
            'category'=>'',
            'tags'=>array()
        ),
        'private'=>array(
            'label'=>'Private',
            '_ref'=>'private',
            '_inactive'=>false,
            'category'=>'',
            'tags'=>array()
        )
    );

    /**
     * Returns a key to value list of display name types.
     * This list can be flat, categorized or a partial list based on tags.
     *
     * @access public
     * @param array $list
     * @param array $tags
     * @param string $catgory
     * @param boolean $categories
     * @return array
     */
    public function listDisplayNameTypes($tags = null, $category = null, $categories = false){
        return $this->_listParser($this->__listDisplayNameTypes, $tags, $category, $categories);
    }

    /**
     * Initialisation for all new instances of Person
     * @access public
     * @param mixed $id Set this ID for this model on startup, can also be an array of options, see above.
     * @param string $table Name of database table to use.
     * @param string $ds DataSource connection name.
     *
     */
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);

        $ds = DS;

        $this->virtualFields = array(
            'name' => "CONCAT(`{$this->alias}`.`first_name`, ' ', `{$this->alias}`.`last_name`)",
            'url' => "CONCAT('/people/view/',`{$this->alias}`.`username`)",
            'admin_url' => "CONCAT('/admin/people/view/',`{$this->alias}`.`username`)",
        );

    }
}