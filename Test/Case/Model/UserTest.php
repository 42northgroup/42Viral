<?php
require_once APP . DS . 'Test' . DS . 'Case' . DS . 'Model' . DS . 'PersonTest.php';
App::uses('User', 'Model');

class UserTest extends PersonTest {
    public $fixtures = array('app.person');

    public function setUp() {
        parent::setUp();
        $this->User = ClassRegistry::init('User');
    }
}