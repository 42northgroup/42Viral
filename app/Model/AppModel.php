<?php

App::uses('Model', 'Model');

/**
 *
 */
class AppModel extends Model 
{
    
    /**
     * Application-wide behaviors
     * @var array
     * @access public
     */
    public $actsAs = array('Containable', 'Log');

}
