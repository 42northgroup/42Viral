<?php
App::import('Lead', 'Model');
require('PersonTest.php');

class LeadTestCase extends PersonTestCase {
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
