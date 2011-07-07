<?php

App::uses('Person', 'Model');

/**
 * Mangages the person object from the POV of a Lead
 * @package App
 * @subpackage App.crm
 */
class Lead extends Person
{
    /**
     * Set the name of the class, this is needed when working with inheirited methods
     * @var string
     */
    var $name = 'Lead';
    
    /**
     * Inject all "finds" against the Lead object with lead filtering criteria
     * @param array $query
     * @return type 
     */
    public function beforeFind(&$query) 
    {
        $leadFilter = array('Lead.object_type' =>'lead');
        $query['conditions'] = array_merge($query['conditions'], $leadFilter);
        return true;
    }
}
?>