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
 * @package app
 * @subpackage app.core
 * 
 * @author Jason D Snider <jason.snider@42viral.org>
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