<?php

App::uses('ContentAbstract', 'Model');

/**
 * Mangages the person object from the POV of a Lead
 * @package App
 * @subpackage App.crm
 */
class PostAbstract extends ContentAbstract
{
    /**
     * Set the name of the class, this is needed when working with inheirited methods
     * @var string
     */
    var $name = 'Post';
    
   /**
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function beforeSave()
    {        
        parent::beforeSave();
        $this->data['Post']['object_type'] = 'post';
        return true;
    }  
    
    /**
     * Inject all "finds" against the Post object with lead filtering criteria
     * @param array $query
     * @return type 
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function beforeFind(&$query) 
    {
        $query['conditions'] =!empty($query['conditions'])?$query['conditions']:array();
        $postFilter = array('Post.object_type' =>'post');
        $query['conditions'] = array_merge($query['conditions'], $postFilter);
        return true;
    }
}
?>
