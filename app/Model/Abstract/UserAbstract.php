<?php
App::uses('PersonAbstract', 'Model');
App::uses('Security', 'Utility'); 

App::uses('Sec', 'Lib'); 
        
/**
 * Mangages the person object from the POV of a contact
 * @package App
 * @subpackage App.core
 */
abstract class UserAbstract extends PersonAbstract
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
        'password' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' =>"Please enter a password",
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
     * @access public
     */
    public function __construct() 
    {
        parent::__construct();
    }
    
    /**
     * To be a user, you must have an email and username
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function beforeFind(&$query) 
    {
        
        $query['conditions'] =!empty($query['conditions'])?$query['conditions']:array();
        $userFilter = array( 
                "not"=>array(
                    "User.username" => null
                )
            );
        $query['conditions'] = array_merge($query['conditions'], $userFilter);

        return true;
    }

    /**
     *
     * @param data array - A 1 deminisonal array focused in the user data
     * @return boolean
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function createUser($data)
    {
        
        //Create a salt value for the user
        $salt = Sec::makeSalt();
        
        //Load salt into the data array
        $data['User']['salt'] = $salt;
        
        //Hash the password and load it into the data array
        $data['User']['password'] = Sec::hashPassword($data['User']['password'], $salt);

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
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function getUser($token)
    {
        $user = $this->find('first', 
                    array(
                        'conditions'=>array(
                            'or'=>array(
                                'User.username'=>$token,
                                'User.email'=>$token
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
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function getProfile($token)
    {
        $user = $this->find('first', 
                    array(
                        'conditions'=>array(
                            'or'=>array(
                                'User.username'=>$token,
                                'User.id'=>$token
                            ),
                        ),
                        'contain'=>array()
                    )
                );
        
        return $user;
    }    
    
}
?>
