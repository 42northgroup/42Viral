<?php

App::uses('AppModel', 'Model');

/**
 * Mangages the person object
 * @package App
 * @subpackage App.core
 */
abstract class PersonAbstract extends AppModel
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
    public $alias = 'Person';
    
    /**
     *
     * @var string
     * @access public
     */
    public $useTable = 'people';
    
    /**
     *
     * @var array
     */
    public $actsAs = array(
        'Picklist' => array(
            'ObjectTypes'=>array(
                'prospect'=>'Prospect',
                'lead'=>'Lead',
                'contact'=>'Contact'
            ),
            
            'DisplayName' => array(
                'name' => 'Name',
                'username' => 'Username',
                'id' => 'User Id'
            )
        ),
        
        'Scrub'=>array(
            'Filters'=>array(
                'trim'=>'*',
                'safe'=>'*'
            )
        )
    );
    
    /**
     * 
     * @var array
     * @access public
     */
    public $hasMany = array(
        'Content' => array(
            'className' => 'Content',
            'foreignKey' => 'created_person_id',
            'dependent' => true
        ),
        'Blog' => array(
            'className' => 'Blog',
            'foreignKey' => 'created_person_id',
            'dependent' => true
        ),        
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'created_person_id',
            'dependent' => true
        ),        
        'Page' => array(
            'className' => 'Page',
            'foreignKey' => 'created_person_id',
            'dependent' => true
        ),
    );
    
    /**
     * @access public
     */
    public function __construct() 
    {
        parent::__construct();
        
        $fileWritePath = FILE_WRITE_PATH;
        $imageWritePath = IMAGE_WRITE_PATH;
        $fileReadPath = FILE_READ_PATH;
        $imageReadPath = IMAGE_READ_PATH;
        $ds = DS;
        
        $this->virtualFields = array(
            'name'=>"CONCAT(`{$this->alias}`.`first_name`, ' ', `{$this->alias}`.`last_name`)",
            'url'=>"CONCAT('/profile/',`{$this->alias}`.`username`)",
            'private_url'=>"CONCAT('/members/view/',`{$this->alias}`.`username`)",
            'file_write_path'=>"CONCAT('{$fileWritePath}',`{$this->alias}`.`id` , '{$ds}')",
            'image_write_path'=>"CONCAT('{$imageWritePath}',`{$this->alias}`.`id` , '{$ds}')",
            'file_read_path'=>"CONCAT('{$fileReadPath}',`{$this->alias}`.`id` , '/')",        
            'image_read_path'=>"CONCAT('{$imageReadPath}',`{$this->alias}`.`id` , '/')"  
        );        
    }
    
    /**
     * Returns the data for a single person
     * @param string $id
     * @return array 
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public 
     */
    public function getPerson($id)
    {
        $person = $this->find('first', array('conditions'=>array($this->name.'.id' => $id)));
        return $person;
    }
    
    /**
     * Parses an array of user data and returns the desired display name
     * @param type $data
     * @return type 
     */
    public function getDisplayName($data){
        return $data[$data['display_name']];
    }
}