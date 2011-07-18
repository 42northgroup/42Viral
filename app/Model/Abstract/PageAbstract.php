<?php

App::uses('ContentAbstract', 'Model');

/**
 * Mangages the person object from the POV of a Lead
 * @package App
 * @subpackage App.crm
 */
abstract class PageAbstract extends ContentAbstract
{
    /**
     * Set the name of the class, this is needed when working with inheirited methods
     * @var string
     */
    var $name = 'Page';
    
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
    
    /**
     * @access public
     */
    public function __construct() 
    {
        parent::__construct();
       
    }
    
   /**
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function beforeSave()
    {        
        parent::beforeSave();
        $model->data['Page']['object_type'] = 'page';
        return true;
    }    
    
    /**
     * Inject all "finds" against the Page object with lead filtering criteria
     * @param array $query
     * @return type 
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function beforeFind(&$query) 
    {
        $query['conditions'] =!empty($query['conditions'])?$query['conditions']:array();
        $pageFilter = array('Page.object_type' =>'page');
        $query['conditions'] = array_merge($query['conditions'], $pageFilter);
        return true;
    }
  
}
?>
