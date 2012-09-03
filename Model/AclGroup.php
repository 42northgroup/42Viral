<?php
/**
 * Manages ACL groups
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
 * @package 42viral\Person\User\Group
 */

App::uses('Group', 'Model');
/**
 * Manages ACL groups
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 * @package 42viral\Person\User\Group
 */
class AclGroup extends Group
{
    /**
     * The static name of the acl group class
     * @access public
     * @var string
     */
    public $name = 'AclGroup';
    
    /**
     * Specifies the table the be used by the acl group model
     * @access public
     * @var string
     */
    public $useTable = 'groups';
    
    /**
     * Specifies validation rules fro the acl group standard
     * @access public
     * @var array
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
     * @access public
     * @param array $queryData
     * @return array 
     */
    public function beforeFind($queryData) {
        parent::beforeFind($queryData);
        
        $queryData['conditions'] =!empty($queryData['conditions'])?$queryData['conditions']:array();
        $aclGroupFilter = array('AclGroup.object_type' =>'acl');
        $queryData['conditions'] =array_merge($queryData['conditions'], $aclGroupFilter);
        
        return $queryData;
    }
    
}