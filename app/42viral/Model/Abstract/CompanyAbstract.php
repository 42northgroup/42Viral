<?php
/**
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppModel', 'Model');

/**
 * Mangages the company object
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
abstract class CompanyAbstract extends AppModel
{
    public $name = 'Company';

    public $hasMany = array(
        'Address' => array(
            'foreignKey' => 'model_id',

            'conditions' => array(
                'model' => 'Company'
            ),

            'dependent' => true
        )
    );

    public function __construct($id=false, $table=null, $ds=null) {
        parent::__construct($id, $table, $ds);
        /*
        $this->virtualFields = array(
            '_sample_virtual_field' => "CONCAT(`{$this->alias}`.`name`)"
        );
        */
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
                'owner_user_id' => $userId
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


    /**
     *
     * @param type $userId
     * @return int 
     */
    public function companyProfileProgress($userId)
    {
        $companies = $this->find('all', array(
            'contain' => array(),

            'conditions' => array(
                'owner_user_id' => $userId
            )
        ));

        $progress = 0;

        if(empty($companies)) {
            $progress;
        } else {
            $progress = 100;
        }

        return $progress;
    }
}