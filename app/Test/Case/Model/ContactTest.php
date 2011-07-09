<?php
App::import('Contact', 'Model');
require(TEST_MODEL . 'PersonTest.php');

class ContactTestCase extends PersonTestCase {
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
        $this->Contact =& ClassRegistry::init('Contact');
    }
    
}
