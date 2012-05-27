<?php
/**
 * Manages the person object with user contraints
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
 * @package 42viral\Person\User
 */

App::uses('AppModel', 'Model');
App::uses('Person', 'Model');
App::uses('Security', 'Utility');
App::uses('Sec', 'Lib');
/**
 * Manages the person object with user contraints
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 * @package 42viral\Person\User
 */
class User extends Person
{
    /**
     * The static name of the user model
     * @access public
     * @var string
     */
    public $name = 'User';

    /**
     * Predefined data sets
     * @access public 
     * @var array
     */
    public $dataSet = array(
        
        'full_profile' => array(
            'contain' =>    array(
                'Address'=>array(),
                'Content'=>array(),
                'PersonDetail'=>array(),
                'Profile'=>array('SocialNetwork'),
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
     * Defines has one relationships for users
     * @access public
     * @var array
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
     * Defines a user's model validation
     * @access public
     * @var array
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
            ),
            
            //Apply rules to the username's format
            'login' => array(
                //May only contain lowercase letters, integers, hyphens and dashes and must be atleast 1 character
                //in length change the {1,} part of the string to adjust the length. Don't forget to include the new
                //length in the error message
                'rule'    => array('custom', '/^(?-i)[a-z0-9_-]{1,}$/i'),
                'message' => 'Only lowercase letters, integers, hyphens and dashes',
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
     * Applies PCI DSS settings to incomming user data prior to validation
     * @access public
     * @return boolean
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
     * Applies user specific conditions to all finds
     * @param array $queryData the data that builds the final CakePHP query.
     * @access public
     * @return array
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
     * @access public
     * @return boolean
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
     * @access public
     * @return boolean
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
     * @access public
     * @return boolean
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
     * @access public
     * @return boolean
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
     * A genrealized method for creating a system user
     * @access public
     * @param data array - A 1 deminisonal array focused in the user data
     * @return boolean
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
     * A generalized method for performing a password change
     * @access public
     * @param data array - A 1 deminisonal array focused in the user data
     * @return array
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
     * @access public
     * @param string $token
     * @param string $with
     * @return array
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
     * @access public
     * @param string $with
     * @return array
     */
    public function fetchUsersWith($with)
    {
        $finder = $this->dataSet[$with];
        
        $users = $this->find('all', $finder);
        
        return $users;
    }

    /**
     * Given a password reset request token find the user record
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
     * Returns true if a given token exsits in a user record
     * @access public
     * @param string $requestToken
     * @return boolean
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