<?php
App::uses('Person', 'Model');

class PersonTest extends CakeTestCase {
    public $fixtures = array('app.person');

    public function setUp() {
        parent::setUp();
        $this->Person = ClassRegistry::init('Person');
    }

    public function testFindRoot() {

        $result = $this->Person->find(
            'first',
            array(
                'conditions'=>array(
                    'Person.username'=>'root'
                ),
                'contain'=>array(),
                'fields'=>array(
                    'Person.username'
                )
            )
        );

        $expected = array('Person' => array('username' => 'root'));

        $this->assertEquals($expected, $result);
    }
}