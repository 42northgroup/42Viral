<?php

App::uses('CompanyAbstract', 'Model');

/**
 * Mangages the person object from the POV of a contact
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
     *
     *
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access public
     * @param string $companyName
     * @return
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
     *
     *
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access public
     * @param type $with
     */
    public function fetchAllCompaniesWith($with=array())
    {
        $companies = $this->find('all', array(
            'contain' => $with
        ));

        return $companies;
    }
}
