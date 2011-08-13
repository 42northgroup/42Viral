<?php

App::uses('PersonAbstract', 'Model');

/**
 * Mangages the person object from the POV of a Lead
 * @package App
 * @subpackage App.crm
 */
abstract class LeadAbstract extends PersonAbstract
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
     * @author Jason D Snider <jsnider77@gmail.com>
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