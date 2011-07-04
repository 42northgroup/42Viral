<?php
App::import('Model', 'Person');

class PersonTestCase extends CakeTestCase {
    var $fixtures = array( 'app.article' );

    function testGetPerson() {
        $this->Person =& ClassRegistry::init('Person');

        $result = $this->Person->getPerson('c9510606-a5bf-11e0-8563-000c29ae9eb4');

        $expected = array(
            array('Person' => 
                array('first_name' => 'test' ))
        );

        $this->assertEqual($result, $expected);
    }
}
?>    
