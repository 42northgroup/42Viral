<?php

App::uses('Person', 'Model');

/**
 * Mangages the person object from the POV of a contact
 */
class Contact extends Person
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
