<?php

App::uses('PersonAbstract', 'Model');

/**
 * Mangages the person object from the POV of a contact
 */
abstract class ContactAbstract extends PersonAbstract
{
    /**
     * Set the name of the class, this is needed when working with inheirited methods
     * @var string
     */
    var $name = 'Contact';
    
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
?>
