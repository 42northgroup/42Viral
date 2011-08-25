<?php

App::uses('CompanyAbstract', 'Model');

/**
 * Mangages the company object
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
class Company extends CompanyAbstract
{

    public $hasMany = array(
        'Address' => array(
            'foreignKey' => 'model_id',

            'conditions' => array(
                'model' => 'Company'
            ),

            'dependent' => true
        )
    );


    /**
     * Fetch a company record with associated model records given the company name
     *
     * @access public
     * @param string $companyName
     * @param array $with
     * @return Company
     */
    public function fetchCompanyByNameWith($companyName, $with=array())
    {
        $normalizedCompanyName = Inflector::underscore($companyName);

        $company = $this->find('first', array(
            'contain' => $with,

            'conditions' => array(
                'Company.name_normalized' => $normalizedCompanyName
            )
        ));

        return $company;
    }


    /**
     * Fetch a given user's companies with associated model records given the user's person id
     *
     * @access public
     * @param string $userId
     * @param array $with
     * @return Company
     */
    public function fetchUserCompaniesWith($userId, $with=array())
    {

        $companies = $this->find('all', array(
            'contain' => $with,

            'conditions' => array(
                'owner_person_id' => $userId
            )
        ));

        return $companies;
    }


    /**
     * Fetch all companies in the system with associated model records
     *
     * @access public
     * @param type $with
     * @return array
     */
    public function fetchAllCompaniesWith($with=array())
    {
        $companies = $this->find('all', array(
            'contain' => $with
        ));

        return $companies;
    }
}
