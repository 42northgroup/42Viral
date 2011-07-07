<?php

App::uses('Person', 'Model');

/**
 * Mangages the person object from the POV of a contact
 * @package App
 * @subpackage App.crm
 */
class Prospect extends Person
{
    /**
     * Set the name of the class, this is needed when working with inheirited methods
     * @var string
     */
    var $name = 'Contact';
    
    /**
     * Inject all "finds" against the Prospect object with prospect filtering criteria
     * @param array $query
     * @return type 
     */
    public function beforeFind(&$query) 
    {
        $prospectFilter = array('Prospect.object_type' =>'prospect');
        $query['conditions'] = array_merge($query['conditions'], $prospectFilter);
        return true;
    }    
}
?>
