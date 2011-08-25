<?php

App::uses('AppModel', 'Model');

/**
 * Mangages the company object
 */
abstract class CompanyAbstract extends Model
{
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


    /**
     *
     *
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access public
     * @return type
     */
    public function beforeSave()
    {
        parent::beforeSave();

        /*
        if(isset($this->data['Company']['name'])) {
            $this->data['Company']['name_normalized'] = strtolower($this->data['Company']['name']);
        }
        */

        return true;
    }
}