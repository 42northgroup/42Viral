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
App::uses('PersonAbstract', 'Model');
App::uses('Security', 'Utility');
App::uses('Sec', 'Lib');

/**
 * Mangages the person object from the POV of a contact
 * 
 * @package app
 * @subpackage app.core
 * 
 **** @author Jason D Snider <jason.snider@42viral.org>
 */
class UserAbstract extends PersonAbstract
{
    /**
     *
     * @var string
     * @access public
     */
    public $name = 'User';

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
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' =>"This email address is already in use",
                'last' => true
            )
        ),
        'password' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' =>"Please enter a password",
                'last' => true
            ),
            'verifyPassword' => array(
                'rule' => 'verifyPassword',
                'message' => 'Your passwords do not match',
                'last' => true
            )
        ),
        'verify_password' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
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
     * To be a user, you must have an email and username
     * @author Jason D Snider <jason.snider@42viral.org>
     * @access public
     */
    public function beforeFind(&$query)
    {

        $query['conditions'] =!empty($query['conditions'])?$query['conditions']:array();
        $userFilter = array(
                "not"=>array(
                    "Username" => null
                )
            );
        $query['conditions'] = array_merge($query['conditions'], $userFilter);

        return true;
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
     *
     * @param data array - A 1 deminisonal array focused in the user data
     * @return boolean
     * @author Jason D Snider <jason.snider@42viral.org>
     * @access public
     * @todo Complete and harden
     */
    public function createUser($data)
    {
        $this->create();

        //Create a salt value for the user
        $salt = Sec::makeSalt();

        //Load salt into the data array
        $data['salt'] = $salt;

        //Hash the password and its verifcation then load it into the data array
        $data['password'] = Sec::hashPassword($data['password'], $salt);
        $data['verify_password'] = Sec::hashPassword($data['verify_password'], $salt);

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
     * @return boolean
     * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
     * @access public
     * @todo Complete and harden
     */
    public function changePassword($data)
    {
        $this->create();

        //Create a salt value for the user
        $salt = Sec::makeSalt();

        //Load salt into the data array
        $data['salt'] = $salt;

        //Hash the password and its verifcation then load it into the data array
        $data['password'] = Sec::hashPassword($data['password'], $salt);
        $data['verify_password'] = Sec::hashPassword($data['verify_password'], $salt);

        //Try to save the new user record
        if($this->save($data)){
            return true;
        }else{
            return false;
        }

    }

    /**
     * Finds a user by username or email
     * @param string $token
     * @return array
     * @author Jason D Snider <jason.snider@42viral.org>
     * @access public
     */
    public function getUser($token)
    {
        $user = $this->find('first',
                    array(
                        'conditions'=>array(
                            'or'=>array(
                                'Username'=>$token,
                                'User.email'=>$token,
                                'User.id'=>$token
                            )
                        ),
                        'contain'=>array()
                    )
                );

        return $user;
    }

    /**
     * Finds a user by username or id
     * @param string $token
     * @return array
     * @author Jason D Snider <jason.snider@42viral.org>
     * @access public
     */
    public function getProfile($token)
    {
        $user = $this->find('first', array(
            'contain' => array(
                'Content',
                'Upload'
            ),

            'conditions' => array(
                'or' => array(
                    'User.id' => $token,
                    'User.username' => $token
                )
            )
        ));

        return $user;
    }

    /**
     * Returns the data for a single user
     *
     * @param string $userId
     * @return array
     * @author Zubin Khavarian <zubin.khavarian@42viral.org>
     * @access public
     */
    public function getUserWith($token, $with=array())
    {
        $person = $this->find('first', array(
            'contain' => $with,

            'conditions' => array(
                'or' => array(
                    'User.id' => $token,
                    'User.username' => $token
                )
            )
        ));

        return $person;
    }

}