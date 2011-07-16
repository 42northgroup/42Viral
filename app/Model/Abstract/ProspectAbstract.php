<?php

App::uses('PersonAbstract', 'Model');

/**
 * Mangages the person object from the POV of a contact
 * @package App
 * @subpackage App.crm
 */
abstract class ProspectAbstract extends PersonAbstract
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
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public 
     */
    public function beforeFind(&$query) 
    {
        $query['conditions'] =!empty($query['conditions'])?$query['conditions']:array();
        $prospectFilter = array('Prospect.object_type' =>'prospect');
        $query['conditions'] = array_merge($query['conditions'], $prospectFilter);
        return true;
    }    
}
?>
