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
 * 
 * @author Jason D Snider <jason.snider@42viral.org>
 */
class Company extends AppModel
{
    
    /**
     * @access public
     */
    public function __construct($id = false, $table = null, $ds = null) 
    { 
        parent::__construct($id, $table, $ds);
        
        $this->virtualFields = array(
            //'admin_view_url'=>"CONCAT('/admin/companies/view/' , `{$this->alias}`.`id`)",
            //'admin_edit_url'=>"CONCAT('/admin/companies/edit/',`{$this->alias}`.`id`)",
            //'admin_delete_url'=>"CONCAT('/admin/companies/delete/',`{$this->alias}`.`id`)",
        );        
    }
    
   /**
    * 
    * @param string $token - id or username for retreving records
    * @return array
    * @access public
    */
    public function fetchCompanyWith($token, $with = array())
    {
        //Allows predefined data associations in the form of containable arrays
        if(!is_array($with)){

            switch(strtolower($with)){
                          
                default:
                    $with = array();
                break;
            }

        }
        
        //Go fetch the company
        $company = $this->find('first', array(
           'contain' => $with,

           'conditions' => array(
               "Company.{$by}"  => $id
           )
        ));

        return $company;        
    }
    
   /**
    * 
    * @param string $token - id or username for retreving records
    * @return array
    * @access public
    */
    public function fetchCompaniesWith($conditions  = array(), $with = array())
    {
        //Allows predefined data associations in the form of containable arrays
        if(!is_array($with)){
            switch(strtolower($with)){
                default:
                    $with = array();
                break;
            }
        }
        
        //Go fetch the company
        $company = $this->find('all', array(
           'conditions'=>$conditions,
           'contain' => $with,
        ));

        return $company;        
    }    
}