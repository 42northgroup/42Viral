<?php
App::uses('AppModel', 'Model');

/**
 * 
 * @package App
 * @subpackage App.core
 */
abstract class InformationSchemaAbstract extends AppModel
{
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'InformationSchema';
    public $useTable = "information_schema";
    
    
}