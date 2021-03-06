<?php
/**
 * Provides a generalized concpet for creating and managing 
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

App::uses('AppModel', 'Model');
/**
 * Provides a generalized concpet for creating and managing 
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral\Person\User\Group
 */
class Group extends AppModel
{
    /**
     * The static name for the group object
     * @var string
     * @access public
     */
    public $name = 'Group';
    
    /**
     * Specifies the table used by the conversation model
     * @access public
     * @var string
     */
    public $useTable = 'groups';
    
    /**
     * Specifies the behaviors invoked by the conversation model
     * @access public
     * @var array
     */
    public $actsAs = array(
        'Scrubable' => array(
            'Filters' => array(
                'trim' => '*',
                'safe' => '*'
            )
        )
    );   
    
}