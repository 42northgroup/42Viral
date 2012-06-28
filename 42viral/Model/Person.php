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
     * Predefined data sets
     * @access public
     * @var array
     */
    public $dataSet = array(
        'blog'=>array(
            'contain'=>array(
                'Profile'=>array(),
                'Blog'=>array(
                    'conditions'=>array(
                        'Blog.object_type'=>'blog',
                        'Blog.status'=>'published'
                        ),
                        'order'=>array('Blog.title ASC')
                    )
            )
        ),
        'nothing'=>array(
            'contain'=>array()
        ),
        'profile' => array(
            'contain' => array('Profile'),
            'conditions' => array()
        ),
        'upload' => array(
            'contain' => array(
                'Profile'=>array(),
                'Upload'=>array()
            ),
            'conditions' => array()
        )
    );

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
    public $hasOne = array(
        //@todo What is this?
        'OwnerPerson' => array(
            'className' => 'Profile',
            'foreignKey' => 'owner_person_id',
            'dependent' => true
        ),

        'Profile' => array(
            'className' => 'Profile',
            'foreignKey' => 'owner_person_id',
            'dependent' => true
        )
    );

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

        'Blog' => array(
            'className' => 'Blog',
            'foreignKey' => 'created_person_id',
            'dependent' => true
        ),
        'Content' => array(
            'className' => 'Content',
            'foreignKey' => 'created_person_id',
            'dependent' => true
        ),
        'Conversation' => array(
            'className' => 'Conversation',
            'foreignKey' => 'created_person_id',
            'dependent' => true
        ),
        'EmailAddress' => array(
            'className' => 'EmailAddress',
            'foreignKey' => 'model_id',
            'conditions'=>array('model'=>'Person'),
            'dependent' => true
        ),
        'FileUpload' => array(
            'className' => 'FileUpload',
            'foreignKey' => 'created_person_id',
            'dependent' => true
        ),

        'Image' => array(
            'className' => 'Image',
            'foreignKey' => 'created_person_id',
            'dependent' => true
        ),
        'Page' => array(
            'className' => 'Page',
            'foreignKey' => 'created_person_id',
            'dependent' => true
        ),
        'PhoneNumber' => array(
            'className' => 'PhoneNumber',
            'foreignKey' => 'model_id',
            'conditions'=>array('model'=>'Person'),
            'dependent' => true
        ),
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'created_person_id',
            'dependent' => true
        ),
        'SocialNetwork' => array(
            'className' => 'SocialNetwork',
            'foreignKey' => 'model_id',
            'conditions'=>array('model'=>'Person'),
            'dependent' => true
        ),
        'Upload' => array(
            'className' => 'Upload',
            'foreignKey' => 'created_person_id',
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

        $fileWritePath = FILE_WRITE_PATH;
        $imageWritePath = IMAGE_WRITE_PATH;
        $fileReadPath = FILE_READ_PATH;
        $imageReadPath = IMAGE_READ_PATH;
        $ds = DS;

        $this->virtualFields = array(
            'name' => "CONCAT(`{$this->alias}`.`first_name`, ' ', `{$this->alias}`.`last_name`)",
            'url' => "CONCAT('/p/',`{$this->alias}`.`username`)",
            'admin_url' => "CONCAT('/admin/people/view/',`{$this->alias}`.`username`)",
            'file_write_path' => "CONCAT('{$fileWritePath}',`{$this->alias}`.`id` , '{$ds}')",
            'image_write_path' => "CONCAT('{$imageWritePath}',`{$this->alias}`.`id` , '{$ds}')",
            'file_read_path' => "CONCAT('{$fileReadPath}',`{$this->alias}`.`id` , '/')",
            'image_read_path' => "CONCAT('{$imageReadPath}',`{$this->alias}`.`id` , '/')"
        );

    }

   /**
    * Returns a person's profile data with the specified associated data.
    * @access public
    * @param string $token The id, username or email address for retreving records
    * @param string|array $with What associated data do we want?
    * @return array
    */
    public function getPersonWith($token, $with = 'nothing')
    {

        $theToken = array(
                'conditions'=>array('or' => array(
                    'Person.id' => $token,
                    'Person.username' => $token,
                    'Person.email' => $token
                ))
        );

        $finder = array_merge($this->dataSet[$with], $theToken);

        $person = $this->find('first', $finder);

        return $person;
    }
}