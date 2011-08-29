<?php  
 class PersonFixture extends CakeTestFixture { 
      var $name = 'Article'; 
       
      var $fields = array( 
          'id' => array('type' => 'string', 'key' => 'primary'), 
          'first_name' => array('type' => 'string', 'length' => 25), 
          'last_name' => array('type' => 'string', 'length' => 25), 
          'created_person_id' => array('type' => 'string', 'null' => false), 
          'created' => 'datetime', 
          'modified_person_id' => array('type' => 'string', 'null' => false), 
      ); 
      var $records = array( 
          array (
              'id' => 'c9510606-a5bf-11e0-8563-000c29ae9eb4', 
              'first_name' => 'test', 
              'last_name' => 'data', 
              'created_person_id'=>'c9510606-a5bf-11e0-8563-000c29ae9eb4',
              'created' => '2011-07-03 00:00:00', 
              'modified_person_id'=>'c9510606-a5bf-11e0-8563-000c29ae9eb4',
              'modified' => '2011-07-03 00:00:00'), 
      ); 
 } 
 ?> 