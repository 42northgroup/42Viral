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
App::uses('Group', 'Model');

/**
 * ACL Groups
 *
 * ACL Groups are used as a template for permission inheiretance
 * 
 * @package app
 * @subpackage app.core
 * 
 *** @author Jason D Snider <jason.snider@42viral.org>
 *** @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 */
class AclGroup extends Group
{
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'AclGroup';
    
    /**
     * 
     * @var string
     * @access public
     */
    public $useTable = 'groups';
    
    /**
     * 
     * @var array
     * @access public
     */
    public $validate = array(
        
        'name' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' =>"Please name the group",
                'last' => true
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' =>"This name is already in use",
                'last' => true                
            )
        ),
        
        'alias' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' =>"Please provide an alias for the group",
                'last' => true
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' =>"This alias is already in use",
                'last' => true                
            )
        )
        
    ); 
    
    /**
     * Inject all "finds" against the Contact object with acl group filtering criteria
     * @param array $query
     * @return type 
     * @access public
     */
    public function beforeFind($queryDataData) {
        parent::beforeFind($queryDataData);
        
        $queryData['conditions'] =!empty($queryData['conditions'])?$queryData['conditions']:array();
        $aclGroupFilter = array('AclGroup.object_type' =>'acl');
        $queryData['conditions'] =array_merge($queryData['conditions'], $aclGroupFilter);
        
        return $queryData;
    }
    
}