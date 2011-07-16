<?php
App::import('Prospect', 'Model');
require('PersonTest.php');

class ProspectTestCase extends PersonTestCase {
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
        $this->Lead =& ClassRegistry::init('Lead');
    }
}
