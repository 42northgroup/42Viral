<?php

App::uses('AppModel', 'Model');

/**
 * Mangages the person object
 * @package App
 * @subpackage App.core
 */
abstract class GroupPersonAbstract extends AppModel
{
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'GroupPerson';
    
    /**
     *
     * @var string
     * @access public
     */
    public $useTable = 'group_people';
    
  
}