<?php

App::uses('ContentAbstract', 'Model');

/**
 * Mangages the person object from the POV of a Lead
 * @package App
 * @subpackage App.crm
 */
abstract class PostAbstract extends ContentAbstract
{
    /**
     * Set the name of the class, this is needed when working with inheirited methods
     * @var string
     */
    var $name = 'Post';
    
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
            ),
            'parent_content_id' => array(
                'rule' => 'notEmpty',
                'message' =>"You need to have a blog attached",
                'last' => true
            ),            
        )
    );
    
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
