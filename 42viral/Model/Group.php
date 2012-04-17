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
 * @package 42viral\Person\User\Permissions
 */

App::uses('AppModel', 'Model');
/**
 * Manages ACL groups
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral\Person\User\Permissions
 */
class Group extends AppModel
{
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'Group';
    
    /**
     *
     * @var string
     * @access public
     */
    public $useTable = 'groups';
    
    /**
     *
     * @var array
     */
    public $actsAs = array(
        'ContentFilters.Scrubable' => array(
            'Filters' => array(
                'trim' => '*',
                'safe' => '*'
            )
        )
    );   
    
}