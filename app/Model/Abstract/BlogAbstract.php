<?php

App::uses('ContentAbstract', 'Model');
App::uses('Scrub', 'Lib');
/**
 * Mangages the person object from the POV of a Lead
 * @package App
 * @subpackage App.crm
 */
abstract class BlogAbstract extends ContentAbstract
{
    /**
     * Set the name of the class, this is needed when working with inheirited methods
     * @var string
     * @access public
     */
    public $name = 'Blog';
    
    /**
     * 
     * @var array
     * @access public
     */
    public $hasMany = array(
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'parent_content_id',
            'dependent' => true
        ),
    );
    
    /**
     * 
     * @var array
     * @access public
     */
    public $validate = array(
        'title' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' =>"Please enter a title",
                'last' => true
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' =>"There is a problem with the slug",
                'last' => true                
            )
        )
    );
    
    
    function __construct($id=false, $table=null, $ds=null) {
        parent::__construct($id, $table, $ds);
        $this->virtualFields = array(
            'url' => "CONCAT('/blog/',`{$this->alias}`.`slug`)"
        );
    }    
    
   /**
     * @access public
     * @author Jason D Snider <jsnider@microtrain.net> 
     */
    public function beforeSave()
    {     
        
        $this->data['Blog']['object_type'] = 'blog';
        return true;
    }  
    
    /**
     * Inject all "finds" against the Blog object with lead filtering criteria
     * @param array $query
     * @return type 
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function beforeFind(&$query) 
    {
        $query['conditions'] =!empty($query['conditions'])?$query['conditions']:array();
        $blogFilter = array('Blog.object_type' =>'blog');
        $query['conditions'] = array_merge($query['conditions'], $blogFilter);
        return true;
    }    
}
?>
