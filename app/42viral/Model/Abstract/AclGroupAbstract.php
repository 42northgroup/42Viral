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
App::uses('GroupAbstract', 'Model');

/**
 * ACL Groups
 *
 * ACL Groups are used as a template for permission inheiretance
 * 
 * @package app
 * @subpackage app.core
 * 
 * @author Jason D Snider <jsnider77@gmail.com>
 * @author Lyubomir R Dimov <lrdimov@yahoo.com>
 */
abstract class AclGroupAbstract extends GroupAbstract
{
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'AclGroup';
    
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
    public function beforeFind(&$query) 
    {
        $query['conditions'] =!empty($query['conditions'])?$query['conditions']:array();
        $aclGroupFilter = array('AclGroup.object_type' =>'acl');
        $query['conditions'] =array_merge($query['conditions'], $aclGroupFilter);
        
        return true;
    }
    
}