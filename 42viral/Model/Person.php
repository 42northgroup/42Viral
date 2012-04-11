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
class Person extends AppModel
{
    /**
     *
     * @var string
     * @access public
     */
    public $name = 'Person';

    /**
     *
     * @var string
     * @access public
     */
    public $useTable = 'people';
        
    /**
     * Predefined data sets
     * @var array
     * @access public 
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
     * Behaviors
     * @var array
     * @access public
     */
    public $actsAs = array(
        'AuditLog.Auditable',
        'ContentFilters.Scrubable' => array(
            'Filters' => array(
                'trim' => '*',
                'safe' => '*'
            )
        )
    );


    /**
     *
     * @var type
     *
     */
    public $hasOne = array(
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
     *
     * @var array
     * @access public
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
        
        'PersonDetail' => array(
            'className' => 'PersonDetail',
            'foreignKey' => 'person_id',
            'dependent' => true
        ),
        
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'created_person_id',
            'dependent' => true
        ),
        
        'Upload' => array(
            'className' => 'Upload',
            'foreignKey' => 'created_person_id',
            'dependent' => true
        )
    );

    /**
     * @access public
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
    * NOTE: When using the by clause please understand, this MUST be a unique index in the profiles table
    * 
    * @param string $token - id or username for retreving records
    * @param string|array $with What associated data do we want?
    * @param string $by - Which token, id or username?
    * @return array
    * @access public
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