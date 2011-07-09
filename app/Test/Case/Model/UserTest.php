<?php
App::import('User', 'Model');
require(TEST_MODEL . 'PersonTest.php');

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
    
    /**
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function testMakeSalt() {
        
        $result = $this->User->testable();

        $expected = array(
            
            //Since the return value is random, the only thing we have to test agaisnt it being an SHA512 hash.
            //all we have to go on for that is strlen()
            'salt' => 128,
            
            //Be sure to update this if their are any changes to the hahing algorithms
            'password' => '4dab1aebb0ef8ded678dce1098b2424fc7a51fab231e90cdb4d9086236574e422c8244a74311d5945a5023f1ca'
                . '8179ef558dc1e0b965e192f06943c73198f20c'
        );

        $this->assertEqual($result, $expected);
    } 
    

}
