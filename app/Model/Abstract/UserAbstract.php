<?php
App::uses('PersonAbstract', 'Model');

App::uses('Upload', 'Model');

App::uses('Security', 'Utility'); 

App::uses('File','Utility');

App::uses('Sec', 'Lib'); 

App::uses('CakeResponse', 'Network');
        
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
     * @var string
     * @access public
     */
    public $alias = 'User';
    
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
                'message' =>"Please varfiy your password",
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
     * @access public
     */
    public function __construct() 
    {
        parent::__construct();
        $this->response = new CakeResponse();
        pr($this->response->getMimeType('xml'));
        pr($this->response->getMimeType('docx'));
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
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo Complete and harden
     */
    public function createUser($data)
    {
        //Create a salt value for the user
        $salt = Sec::makeSalt();
        
        //Load salt into the data array
        $data['salt'] = $salt;
        
        //Hash the password and its verifcation then load it into the data array
        $data['password'] = Sec::hashPassword($data['password'], $salt);
        $data['verify_password'] = Sec::hashPassword($data['verify_password'], $salt);
        
        //Try to save the new user record
        if($this->save($data)){

            Upload::userWritePaths($this->id);
            
            return true;
        }else{
            return false;
        }

    }  
    
    /**
     * Sets a new profile image by writing any image under a users controll to profile.png
     * @param type $path
     * @return type 
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function setProfileImage($path){
        
        $file = new File($path);
        
        if($file->copy(IMAGE_WRITE_PATH . DS . 'profile.png')){
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
                        'contain'=>array(
                            'Content' => array()
                        )
                    )
                );
        
        return $user;
    }    
    
}