<?php
App::import('Model', 'Person');

class PersonTestCase extends CakeTestCase {
    
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
        $this->Person =& ClassRegistry::init('Person');
    }

    /**
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function testGetPerson() {
        
        $result = $this->Person->getPerson('c9510606-a5bf-11e0-8563-000c29ae9eb4');

        $expected = array(
            'Person' => array(
                'id' => 'c9510606-a5bf-11e0-8563-000c29ae9eb4',
                'email' => NULL,
                'username' => NULL,
                'password' => NULL,
                'salt' => NULL,
                'first_name' => 'test',
                'last_name' => 'data',
                'object_type' => 'prospect',
                'created' => '2011-07-03 00:00:00',
                'created_person_id' => 'c9510606-a5bf-11e0-8563-000c29ae9eb4',
                'modified' => '2011-07-03 00:00:00',
                'modified_person_id' => 'c9510606-a5bf-11e0-8563-000c29ae9eb4'
            )
        );

        $this->assertEqual($result, $expected);
    }
}
?>    
