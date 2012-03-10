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
App::uses('Person', 'Model');

/**
 * Mangages the person object from the POV of a Lead
 * 
 * @package app
 * @subpackage app.core
 * 
 * @author Jason D Snider <jason.snider@42viral.org>
 */
class Lead extends Person
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
     * @access public
     */
    public function beforeFind($queryData) {
        parent::beforeFind($queryData);
        
        $queryData['conditions'] =!empty($queryData['conditions'])?$queryData['conditions']:array();
        $leadFilter = array('Lead.object_type' =>'lead');
        $queryData['conditions'] = array_merge($queryData['conditions'], $leadFilter);
        
        return $queryData;
    }
}