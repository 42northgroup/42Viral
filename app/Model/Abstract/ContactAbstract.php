<?php

App::uses('PersonAbstract', 'Model');

/**
 * Mangages the person object from the POV of a contact
 */
abstract class ContactAbstract extends PersonAbstract
{
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'Contact';
    
    /**
     * 
     * @var string
     * @access public
     */
    public $alias = 'Contact';
    
    /**
     * Inject all "finds" against the Contact object with contact filtering criteria
     * @param array $query
     * @return type 
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function beforeFind(&$query) 
    {
        $query['conditions'] =!empty($query['conditions'])?$query['conditions']:array();
        $contactFilter = array('Contact.object_type' =>'contact');
        $query['conditions'] =array_merge($query['conditions'], $contactFilter);
        
        return true;
    }
    
}