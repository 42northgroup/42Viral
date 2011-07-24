<?php
App::uses('PersonAbstract', 'Model');
App::uses('Security', 'Utility'); 
App::uses('File','Utility');

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
     * @todo Complete and harden
     */
    public function createUser($data)
    {
        //Create a salt value for the user
        $salt = Sec::makeSalt();
        
        //Load salt into the data array
        $data['salt'] = $salt;
        
        //Hash the password and load it into the data array
        $data['password'] = Sec::hashPassword($data['password'], $salt);
        
        //Try to save the new user record
        if($this->save($data)){
            $this->__buildUserPaths($this->id);
            return true;
        }else{
            return false;
        }

    }  
    
    /**
     * Builds the file paths for a new user
     * @param string $id 
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access private
     * @todo Complete and harden
     */
    private function __buildUserPaths($id)
    {
        //Calling the same method twice seems to make the app angry for no good reason, thus @
        @Folder::create(FILE_WRITE_PATH . DS . $id);

        @Folder::create(IMAGE_WRITE_PATH . DS . $id);

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