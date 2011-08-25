<?php

App::uses('AppModel', 'Model');

/**
 * Mangages the company object
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
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access public
     * @param type $userId
     * @return type
     */
    public function fetchUserCompany($userId)
    {

        $companies = $this->find('first', array(
            'contain' => array(),

            'conditions' => array(
                'owner_person_id' => $userId
            )
        ));

        return $companies;
    }

    /**
     *
     *
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access public
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
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
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
     *
     *
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
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