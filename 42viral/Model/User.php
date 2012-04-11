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

App::uses('AppModel', 'Model');
App::uses('Person', 'Model');
App::uses('Security', 'Utility');
App::uses('Sec', 'Lib');
/**
 * Mangages the person object from the POV of a contact
 * 
 * @package app
 * @subpackage app.core
 * 
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 */
class User extends Person
{
    /**
     *
     * @var string
     * @access public
     */
    public $name = 'User';

    /**
     * Predefined data sets
     * @var array
     * @access public 
     */
    public $dataSet = array(
        
        'full_profile' => array(
            'contain' =>    array(
                'Address'=>array(),
                'Content'=>array(),
                'PersonDetail'=>array(),
                'Profile'=>array(),
                'Upload'=>array(),
                'UserSetting'=>array()
            ),
            'conditions' => array()
        ),
        'nothing'=>array(
            'contain'=>array()
        ),
        'profile' => array(
            'contain' =>    array(
                'Profile'=>array()
            ),
            'conditions' => array()
        ), 
        
        'session_data' => array(
            'contain' =>    array(
                'Profile'=>array(),
                'UserSetting'=>array(),
            ),
            'conditions' => array()
        )
    ); 

    /**
     *
     * @var array
     * @access public
     */
    public $hasOne = array(
        'Profile' => array(
            'className' => 'Profile',
            'foreignKey' => 'owner_person_id',
            'dependent' => true
        ),
        'UserSetting' => array(
            'className' => 'UserSetting',
            'foreignKey' => 'person_id',
            'dependent' => true
        )
    );
    
    /**
     *
     * @var array
     * @access public
     * @todo Write custom validation rules for determinging if the hased password is the hash of an empty string.
     * This must consider the use of system salt
     */
    public $validate = array(
        'username' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' =>"Please enter username",
                'last' => true
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' =>"This username is already in use",
                'last' => true
            )
        ),
        'email' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' =>"Please enter an email address",
                'last' => true
            ),
            'email' => array(
                'rule' => 'email',
                'message' =>"Please enter a valid email.",
                'last' => true
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' =>"This email address is already in use",
                'last' => true
            )
        ),
        'password' => array(
            'notEmpty' => array(
                'rule' => 'emptyPassword',
                'message' =>"Please enter a password",
                'last' => true
            ),
            'verifyPassword' => array(
                'rule' => 'verifyPassword',
                'message' => 'Your passwords do not match',
                'last' => true
            ),
            'minimalLength' => array(
                'rule' => 'minimalLength',
                'message' => "Password must be at least 7 characters long.",
                'last' => true
            ),
            'forceAlphaNumeric' => array(
                'rule'    => 'forceAlphaNumeric',
                'message' => 'password must contain letters and numbers.',
                'last' => true
            ),
            'forceSpecialChars' => array(
                'rule'    => 'forceSpecialChars',
                'message' => 'password must contain special characters.',
                'last' => true
            ),
            'checkPreviousPasswords' => array(
                'rule' => 'checkPreviousPasswords',
                'message' => 'Your password needs to different from the last 4 passwords you used',
                'last' => true
            )
        ),
        'verify_password' => array(
            'notEmpty' => array(
                'rule' => 'emptyPassword',
                'message' =>"Please verfiy your password",
                'last' => true
            ),
            'verifyPassword' => array(
                'rule' => 'verifyPassword',
                'message' => 'Your passwords do not match',
                'last' => true
            )
        ),
        'salt' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' =>"There was a problem creating your salt",
                'last' => true
            )
        ),
    );
    
    /**
     * pre validation callback
     * @return boolean
     * @access public
     */
    public function beforeValidate()
    {                                
        if(Configure::read('Password.alphanumeric') == 0){
            unset($this->validate['password']['forceAlphaNumeric']);
        }
        
        if(Configure::read('Password.specialChars') == 0){
            unset($this->validate['password']['forceSpecialChars']);
        }
        
        if(Configure::read('Password.difference') == 0){
            unset($this->validate['password']['checkPreviousPasswords']);
        }else{
        
            $this->validate['password']['checkPreviousPasswords']['message'] = 
                    "Your password needs to be different from the last "
                    .Configure::read('Password.difference')." passwords you used";
        }
        
        if(Configure::read('Password.minLength') == 0){
            unset($this->validate['password']['minimalLength']);
        }else{
            $this->validate['password']['minimalLength']['message'] = 
                    "Password must be at least  "
                    .Configure::read('Password.minLength')." characters long";
        }
        
        return true;
    }

    /**
     * To be a user, you must have an email and username
     * @return array
     * @access public
     */
    public function beforeFind($queryData) {
        parent::beforeFind($queryData);

        $queryData['conditions'] =!empty($queryData['conditions'])?$queryData['conditions']:array();
        $userFilter = array(
                "not"=>array(
                    "Username" => null
                )
            );
        $queryData['conditions'] = array_merge($queryData['conditions'], $userFilter);

        return $queryData;
    }


    /**
     * Returns true if the user has submitted the same password twice.
     * @return boolean
     * @author Jason D Snider <jsnider@microtain.net>
     * @access public
     */
    public function verifyPassword()
    {
        $valid = false;
        if ($this->data[$this->alias]['password'] == $this->data[$this->alias]['verify_password']) {
            $valid = true;
        }
        return $valid;
    }
    
    /**
     * Returns true if the user has has entered both numeric and alphabetical characters.
     * @return boolean
     * @author Lyubomir R Dimov <lrdimov@yahoo.com>
     * @access public
     */
    public function forceAlphaNumeric()
    {   
        $valid = false;
        if (!ctype_alpha($this->data[$this->alias]['temp_password']) 
                && !ctype_digit($this->data[$this->alias]['temp_password'])){
            $valid = true;
        }
        
        return $valid;
    }
    
    /**
     * Returns true if the user has has entered special characters.
     * @return boolean
     * @author Lyubomir R Dimov <lrdimov@yahoo.com>
     * @access public
     */
    public function forceSpecialChars()
    {   
        $valid = false;
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/',$this->data[$this->alias]['temp_password'])){
            $valid = true;
        }
        
        return $valid;
    }
    
    /**
     * Check if passwords is at least 7 characters long
     * @return boolean
     * @author Lyubomir R Dimov <lrdimov@yahoo.com>
     * @access public
     */
    public function minimalLength()
    {        
        $valid = false;
        if (strlen($this->data[$this->alias]['temp_password']) > Configure::read('Password.minLength')){
            $valid = true;
        }
        
        return $valid;
    }
    
    /**
     * Check if the password is different than the previous passwords
     * @return boolean
     * @author Lyubomir R Dimov <lrdimov@yahoo.com>
     * @access public
     */
    public function checkPreviousPasswords()
    {
        $valid = false;
        $match = 0;
        
        if(!isset ($this->data[$this->alias]['OldPassword'])){
            $valid = true;
        }else{
            foreach ($this->data[$this->alias]['OldPassword'] as $oldPassword){
                
                $password = Sec::hashPassword($this->data[$this->alias]['temp_password'], 
                                                                                $oldPassword['OldPassword']['salt']);
                
                if($password == $oldPassword['OldPassword']['password']){
                    $match = 1;
                }
            }
            
            if($match == 0){
                $valid = true;
            }
        }
        
        return $valid;
    }

    /**
     * Validation function for checking if the entered password is empty or not
     *
     * @access public
     * @param array $check
     * @return boolean
     */
    public function emptyPassword($check)
    {
        $field = key($check);
        $value = trim($check[$field]);

        if ($value == '') {
            return false;
        } else {
            return true;
        }
    }

    /**
     *
     * @param data array - A 1 deminisonal array focused in the user data
     * @return boolean
     * @access public
     */
    public function createUser($data)
    {
        $this->create();

        //Create a salt value for the user
        $salt = Sec::makeSalt();

        //Load salt into the data array
        $data['salt'] = $salt;

        $data['temp_password'] = $data['password'];
        
        //Hash the password and its verifcation then load it into the data array        
        $data['password'] = Sec::hashPassword($data['password'], $salt);
        $data['verify_password'] = Sec::hashPassword($data['verify_password'], $salt);
                
        //set expiration date for the password
        $data['password_expires'] = date("Y-m-d H:i:s", strtotime("+".Configure::read('Password.expiration')." Days"));
        
        //set number of invitations alotted per user
        $data['invitations_available'] = Configure::read('Beta.invitations');
        
        //Try to save the new user record
        if($this->save($data)){
            $userProfile = array();
            $userProfile['owner_person_id'] = $this->id;
            $this->Profile->save($userProfile);

            return true;
        }else{
            return false;
        }

    }
    
    /**
     *
     * @param data array - A 1 deminisonal array focused in the user data
     * @return array
     * @access public
     */
    public function changePassword($data)
    {
        $this->create();

        //Create a salt value for the user
        $salt = Sec::makeSalt();

        //Load salt into the data array
        $data['salt'] = $salt;
        
        
        $data['temp_password'] = $data['password'];
                
        //Hash the password and its verifcation then load it into the data array
        $data['password'] = Sec::hashPassword($data['password'], $salt);
        $data['verify_password'] = Sec::hashPassword($data['verify_password'], $salt);        
        
        //set expiration date for the password
        $data['password_expires'] = date("Y-m-d H:i:s", strtotime("+".Configure::read('Password.expiration')." Days"));

        //Clear out any password reset request tokens along with a successfull password reset
        $data['pw_reset_token'] = null;
        $data['pw_reset_token_expiry'] = null;
                
        //Try to save the new user record
        if($this->save($data)){
            $_SESSION['Auth']['User']['password_expires'] = $data['password_expires'];
            
            return array('password' => $data['password'], 'salt' => $data['salt']);
        }else{
            return array();
        }
    }

    
    /**
     * Finds a user by id, username or email and returns the requsted data set
     * @param string $token
     * @return array
     * @access public
     */
    public function getUserWith($token, $with)
    {

        $theToken = array(
                'conditions'=>array('or' => array(
                    'User.id' => $token,
                    'User.username' => $token,
                    'User.email' => $token
                ))
        );

        $finder = array_merge($this->dataSet[$with], $theToken);
        
        $user = $this->find('first', $finder);

        return $user;
    }
    
    /**
     * An alias for getUserWith
     *
     * @param string $userId
     * @return array
     * @access public
     */
    public function fetchUsersWith($with)
    {
        $finder = $this->dataSet[$with];
        
        $users = $this->find('all', $finder);
        
        return $users;
    }

    /**
     * Given a password reset request token find the user record
     *
     * @access public
     * @param string $requestToken
     * @return array
     */
    public function getUserFromResetToken($requestToken)
    {
        $user = $this->find('first', array(
            'contain' => array(),

            'conditions' => array(
                'pw_reset_token' => $requestToken
            )
        ));

        return $user;
    }

    /**
     * 
     *
     * @access public
     * @param type $requestToken
     * @return type
     */
    public function checkPasswordResetTokenIsValid($requestToken)
    {
        $user = $this->find('first', array(
            'contain' => array(),

            'conditions' => array(
                'pw_reset_token' => $requestToken
            ),

            'fields' => array(
                'pw_reset_token', 'pw_reset_token_expiry'
            )
        ));


        if(empty($user)) {
            $this->log('nothing found');

            return false;
        }

        $tokenExpiry = strtotime($user['User']['pw_reset_token_expiry']);
        $rightNow = mktime();

        $this->log($tokenExpiry);
        $this->log($rightNow);

        if($tokenExpiry >= $rightNow) {
            $this->log('token not expired');

            return true;
        } else {
            $this->log('token expired');

            return false;
        }
    }

}