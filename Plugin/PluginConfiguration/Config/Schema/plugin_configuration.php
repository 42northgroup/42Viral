<?php 
class PluginConfigurationSchema extends CakeSchema {
    
    /**
     * Name
     *
     * @var string
     * @access public
     */
    public $name = 'PluginConfiguration';
    
    /**
     * Before callback
     *
     * @param string Event
     * @return boolean
     * @access public
     */
	public function before($event = array()) {
		return true;
	}

    /**
     * After callback
     *
     * @param string Event
     * @return boolean
     * @access public
     */
	public function after($event = array()) {
	}
    
    /**
     * Schema for audit_deltas table
     *
     * @var array
     * @access public
     */
	public $configurations = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'value' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'comment' => 'The value of a configuration varaible', 'charset' => 'latin1'),
                'type' => array('type' => 'string', 'null' => true, 'default' => 'string', 'length' => 100, 'collate' => 'latin1_swedish_ci', 'comment' => 'We should add quotes if it is a string type', 'charset' => 'latin1'),	
                'created_person_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified_person_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);
}
