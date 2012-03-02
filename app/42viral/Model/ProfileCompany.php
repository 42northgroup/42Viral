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
 * Mangages the profile company object
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
class ProfileCompany extends AppModel
{
    public $name = 'ProfileCompany';
    
    /**
     *
     * @var string
     * @access public
     */
    public $useTable = 'profile_companies';
    
    public $hasMany = array(
        'Address' => array(
            'foreignKey' => 'model_id',

            'conditions' => array(
                'model' => 'ProfileCompany'
            ),

            'dependent' => true
        )
    );
    
    /**
     *
     * @var array
     * @access public
     */
    public $actsAs = array(

        'ContentFilters.Scrubable'=>array(
            'Filters'=>array(
                'trim'=>'*',
                'noHtml'=>array('name', 'description', 'keywords', 'phone1'),
                'htmlStrict'=>array('body'),
            )
        ),
        
        'Seo.Seo'=>array('convert'=>'name')
    );
    
    public function __construct($id=false, $table=null, $ds=null) {
        parent::__construct($id, $table, $ds);
        
        $this->virtualFields = array(
            'public_url' => "CONCAT('/c/',`{$this->alias}`.`slug`)",
            'edit_url' => "CONCAT('/profile_companies/edit/',`{$this->alias}`.`slug`)",
            'delete_url' => "CONCAT('/profile_companies/delete/',`{$this->alias}`.`id`)"
        );
       
    }


    /**
     * Fetch a given user's companies with associated model records given the user's person id
     *
     * @access public
     * @param string $userId
     * @param array $with
     * @return ProfileCompany
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
     * @param array $with
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
     * Fetch a profile company record with associated model records given the profile company name
     *
     * @access public
     * @param string $companyName
     * @param array $with
     * @return ProfileCompany
     */
    public function fetchCompanyWith($slug, $with=array())
    {
        $company = $this->find('first', array(
            'contain' => $with,

            'conditions' => array(
                'ProfileCompany.slug' => $slug
            )
        ));

        return $company;
    }


    /**
     * Given a company name find out the company id
     *
     * @access public
     * @param string $companyName
     * @return boolean|ProfileCompany
     */
    public function findCompanyIdFromName($companyName)
    {
        $company = $this->fetchCompanyByName($companyName);

        if(!empty($company)) {
            return $company['ProfileCompany']['id'];
        } else {
            return false;
        }
    }


    /**
     * Calculate the company profile progress based on company records created by the given user
     *
     * @access public
     * @param string $userId
     * @return integer
     */
    public function companyProfileProgress($userId)
    {
        $companies = $this->find('all', array(
            'contain' => array(),

            'conditions' => array(
                'owner_person_id' => $userId
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