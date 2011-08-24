<?php

App::uses('CompanyAbstract', 'Model');

/**
 * Mangages the person object from the POV of a contact
 */
class Company extends CompanyAbstract {
    //public $name = 'Company';

    public function fetchUserCompany($userId)
    {

        $companies = $this->find('first', array(
            'conditions' => array(
                'owner_person_id' => $userId
            )
        ));

        return $companies;
    }
}