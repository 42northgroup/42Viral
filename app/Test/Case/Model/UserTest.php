<?php
App::import('User', 'Model');
require('PersonTest.php');

class UserTestCase extends PersonTestCase {
    /**
     * If we have any fitures, call them here
     * @var array
     */
    var $fixtures = array();
    
    /**
     * 
     * @access public
     */
    public function __construct() {
        parent::__construct();
        $this->User =& ClassRegistry::init('User');
    }
    
}
