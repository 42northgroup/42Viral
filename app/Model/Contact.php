<?php

App::uses('Person', 'Model');

/**
 * Mangages the person object from the POV of a contact
 */
class Contact extends Person
{
    var $useTable = 'People';
    /*
    public function beforeFind($conditions) {
        
        $conditions['conditions']['Contact.id'] = 'c9510606-a5bf-11e0-8563-000c29ae9eb4';
        
        return $conditions;
    } */
}
?>
