<?php

App::uses('CompanyAbstract', 'Model');

/**
 * Mangages the person object from the POV of a contact
 */
class Company extends CompanyAbstract {
    public $name = 'Company';

    public function __construct($id=false, $table=null, $ds=null) {
        parent::__construct($id, $table, $ds);
        $this->virtualFields = array(
            '_full_address' => "CONCAT(
                `{$this->alias}`.`addr_line1`, ' ',
                `{$this->alias}`.`addr_line2`, ' ',
                `{$this->alias}`.`addr_city`, ', ',
                `{$this->alias}`.`addr_state`, ' ',
                `{$this->alias}`.`addr_zip`
            )"
        );
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
        $normalizedCompanyName = strtolower($companyName);

        $company = $this->find('first', array(
            'contain' => array(),
            
            'conditions' => array(
                'Company.name_normalized' => $normalizedCompanyName
            )
        ));

        return $company;
    }

}
