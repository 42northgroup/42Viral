<?php

App::uses('Content', 'Model');

/**
 * Mangages the person object from the POV of a Lead
 * @package App
 * @subpackage App.crm
 */
class Blog extends Content
{
    /**
     * Set the name of the class, this is needed when working with inheirited methods
     * @var string
     */
    var $name = 'Blog';
    
    var $hasMany = array(
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'parent_content_id',
            'dependent' => true
        ),
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
