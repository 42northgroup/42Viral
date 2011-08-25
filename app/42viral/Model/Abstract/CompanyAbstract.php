<?php

App::uses('AppModel', 'Model');

/**
 * Mangages the company object
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
abstract class CompanyAbstract extends AppModel
{
    public $name = 'Company';

    public function __construct($id=false, $table=null, $ds=null) {
        parent::__construct($id, $table, $ds);
        /*
        $this->virtualFields = array(
            '_sample_virtual_field' => "CONCAT(`{$this->alias}`.`name`)"
        );
        */
    }

    /**
     * Fetch user companies of a given user
     *
     * @access public
     * @param string $userId
     * @return array
     */
    public function fetchUserCompanies($userId)
    {

        $companies = $this->find('all', array(
            'contain' => array(),

            'conditions' => array(
                'owner_person_id' => $userId
            )
        ));

        return $companies;
    }

    /**
     * Fetch all companies in the system
     *
     * @access public
     * @return array List of all companies
     */
    public function fetchAllCompanies()
    {
        $companies = $this->find('all', array(
            'contain' => array()
        ));

        return $companies;
    }

    /**
     * Given a normalized company name, fetch the company record
     *
     * @access public
     * @param
     * @return
     */
    public function fetchCompanyByName($companyName)
    {
        $normalizedCompanyName = Inflector::underscore($companyName);

        $company = $this->find('first', array(
            'contain' => array(),

            'conditions' => array(
                'Company.name_normalized' => $normalizedCompanyName
            )
        ));

        return $company;
    }


    /**
     * Given a company name find out the company id
     *
     * @access public
     * @param type $companyName
     * @return type
     */
    public function findCompanyIdFromName($companyName)
    {
        $company = $this->fetchCompanyByName($companyName);

        if(!empty($company)) {
            return $company['Company']['id'];
        } else {
            return false;
        }
    }
}