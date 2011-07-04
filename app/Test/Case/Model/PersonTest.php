<?php
App::import('Model', 'Person');

class PersonTestCase extends CakeTestCase {
    var $fixtures = array( 'app.article' );

    function testGetPerson() {
        $this->Person =& ClassRegistry::init('Person');

        $result = $this->Person->getPerson('c9510606-a5bf-11e0-8563-000c29ae9eb4');

        $expected = array(
            'Person' => array(
                'id' => 'c9510606-a5bf-11e0-8563-000c29ae9eb4',
                'first_name' => 'test',
                'last_name' => 'data',
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
