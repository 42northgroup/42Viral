<?php
/**
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::import('Model', 'Person');

class PersonTestCase extends CakeTestCase 
{

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
