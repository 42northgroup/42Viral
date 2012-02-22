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
class Account extends AppModel
{
    public $actsAs = array(
        'AuditLog.Auditable'
    );
    /**
     * @access public
     */
    public function __construct($id = false, $table = null, $ds = null) 
    { 
        parent::__construct($id, $table, $ds);
        
        $this->virtualFields = array(
            'admin_view_url'=>"CONCAT('/admin/accounts/view/' , `{$this->alias}`.`id`)",
            'admin_edit_url'=>"CONCAT('/admin/accounts/edit/',`{$this->alias}`.`id`)",
            'admin_delete_url'=>"CONCAT('/admin/accounts/delete/',`{$this->alias}`.`id`)",
        );        
    }
    
   /**
    * 
    * @param string $token - id or username for retreving records
    * @return array
    * @access public
    */
    public function fetchAccountWith($token, $with = array(), $by = 'id')
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
        $account = $this->find('first', array(
           'contain' => $with,

           'conditions' => array(
               "Account.{$by}"  => $token
           )
        ));

        return $account;        
    }
    
   /**
    * 
    * @param string $token - id or username for retreving records
    * @return array
    * @access public
    */
    public function fetchAccountsWith($conditions  = array(), $with = array())
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
        $accounts = $this->find('all', array(
           'conditions'=>$conditions,
           'contain' => $with,
        ));

        return $accounts;        
    }    
}