<?php
/**
 * PersonFixture
 *
 */
class PersonFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'first_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 25, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'last_name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 25, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'bio' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'username' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'password' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'salt' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'password_expires' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'login_attempts' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1),
		'last_login_attempt' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'password_reset_token' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'latin1_swedish_ci', 'comment' => 'Password reset token for when user requests a password reset (expires after a given period)', 'charset' => 'latin1'),
		'password_reset_token_expiry' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'Password reset token\'s expiry time after which the token is considered invalid and a new one needs to be generated if needed'),
		'employee' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'Set to 1 if the person is an employee'),
		'two_factor_on' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'comment' => 'When set to 1, this user will be forced to use two factor authentication'),
		'two_factor_hash' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 128, 'collate' => 'latin1_swedish_ci', 'comment' => 'The hash of the currently active second factor token', 'charset' => 'latin1'),
		'two_factor_expiry' => array('type' => 'integer', 'null' => false, 'default' => null, 'comment' => 'The timestamp upon which the current second factor token expires'),
		'object_type' => array('type' => 'string', 'null' => false, 'default' => 'prospect', 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'invitations_available' => array('type' => 'integer', 'null' => true, 'default' => null),
		'access' => array('type' => 'string', 'null' => false, 'default' => 'public', 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created_person_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified_person_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '4e24236d-6bd8-48bf-ac52-7cce4bb83359',
			'first_name' => null,
			'last_name' => null,
			'bio' => null,
			'email' => null,
			'username' => 'system',
			'password' => null,
			'salt' => null,
			'password_expires' => '0000-00-00 00:00:00',
			'login_attempts' => '0',
			'last_login_attempt' => null,
			'password_reset_token' => null,
			'password_reset_token_expiry' => null,
			'employee' => 0,
			'two_factor_on' => 0,
			'two_factor_hash' => null,
			'two_factor_expiry' => '0',
			'object_type' => 'system',
			'invitations_available' => null,
			'access' => 'private',
			'created' => '2011-07-21 01:46:22',
			'created_person_id' => '4e24236d-6bd8-48bf-ac52-7cce4bb83359',
			'modified' => '2011-07-21 01:46:22',
			'modified_person_id' => '4e24236d-6bd8-48bf-ac52-7cce4bb83359'
		),
		array(
			'id' => '4e27efec-ece0-4a36-baaf-38384bb83359',
			'first_name' => null,
			'last_name' => null,
			'bio' => null,
			'email' => 'root@example',
			'username' => 'root',
			'password' => '76dc6548481fad479c2017a1488d3b463cc78d766774e24e2ff2686079229cb1df787e679ba614cee1675e93e128491199d29626fa7977cfb9983663ba131800',
			'salt' => 'cf41a748bd089beba6d812ef19df8de60fb396cd5ef8dd6a4c34d5893dfd07fb3b95ec5c3fa870a9f133a4d4d3f7b5421c716528b18cebecd2737fc821d2de2d',
			'password_expires' => '1969-12-31 18:00:00',
			'login_attempts' => '0',
			'last_login_attempt' => null,
			'password_reset_token' => null,
			'password_reset_token_expiry' => null,
			'employee' => 0,
			'two_factor_on' => 0,
			'two_factor_hash' => null,
			'two_factor_expiry' => '0',
			'object_type' => 'prospect',
			'invitations_available' => '25',
			'access' => 'public',
			'created' => '2011-07-21 01:46:22',
			'created_person_id' => '4e24236d-6bd8-48bf-ac52-7cce4bb83359',
			'modified' => '2012-09-03 16:36:35',
			'modified_person_id' => '4e27efec-ece0-4a36-baaf-38384bb83359'
		),
	);

}
