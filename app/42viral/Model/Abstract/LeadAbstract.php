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
App::uses('PersonAbstract', 'Model');

/**
 * Mangages the person object from the POV of a Lead
 * 
 * @package app
 * @subpackage app.core
 * 
 **** @author Jason D Snider <jason.snider@42viral.org>
 */
class LeadAbstract extends PersonAbstract
{
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'Lead';
    
    /**
     * Inject all "finds" against the Lead object with lead filtering criteria
     * @param array $query
     * @return type 
     * @author Jason D Snider <jason.snider@42viral.org>
     * @access public
     */
    public function beforeFind(&$query) 
    {
        $query['conditions'] =!empty($query['conditions'])?$query['conditions']:array();
        $leadFilter = array('Lead.object_type' =>'lead');
        $query['conditions'] = array_merge($query['conditions'], $leadFilter);
        return true;
    }
}