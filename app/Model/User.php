<?php
App::uses('Person', 'Model');
App::uses('Security', 'Utility'); 
        
/**
 * Mangages the person object from the POV of a contact
 * @package App
 * @subpackage App.core
 */
class User extends Person
{
    
    /**
     * @access public
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * To be a user, you must have an email and username
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function beforeFind(&$query) {
        
        $query['conditions'] =!empty($query['conditions'])?$query['conditions']:array();
        $userFilter = array( 
            'conditions'=>array(
                "not"=>array(
                    "User.email" => null,
                    "User.username" => null
                    )
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
    public function createUser($data){
        
        //Get the variables
        extract($data);
  
        //Clean out the usersubmitted password
        unset($data['password']);
        
        //Create a salt value for the user
        $salt = $this->__makeSalt();
        
        //Load salt into the data array
        $data['salt'] = $salt;
        
        //Hash the password and load it into the data array
        $data['password'] = $this->__hashPassword($password, $salt);
        
        //Try to save the new user record
        if($this->save($data)){
            return true;
        }else{
            return false;
        }

    }    
    
    /**
     * Creates some pseudo random jibberish to be used as a salt value.
     * @return string
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access private
     */
    private function __makeSalt(){
        //Why 4096? - Well, why not?
        $seed = openssl_random_pseudo_bytes(4096);
        $seed .= String::uuid();
        $seed .= mt_rand(1000000000, 2147483647);
        $seed .= Security::hash(php_ini_loaded_file(), 'sha512', true);
        
        if(is_dir(DS . 'var')){
            $seed .= Security::hash(implode(scandir(DS . 'var')), 'sha512');
        }

        $salt = $hash = Security::hash($seed, 'sha512', true);
        
        return $salt;
    }
    
    /**
     * Creates a hash that represents a users password.
     * Why $userHash? - this reduces the feasiblity of building a rainbow table against all users in the system to 0.  
     * @param string $password, The string the user has submitted as their password.
     * @param string $salt, The users unique salt value.
     * @return string
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access private
     */
    private function __hashPassword($password, $salt){
        $preHash = Configure::read('Security.salt');
        $preHash .= $salt;
        $preHash .= Security::hash($password, 'sha512', true); 
        
        $hash = Security::hash($preHash, 'sha512', true);
        
        return $hash;
    }
    
    /**
     * Allows access to private methods for running test cases.
     * @return array
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function testable(){
        
        $results = array();
        
        $salt = '345e3d73dbbb6fea3dbd4019d17f3ec16a7f88c258e49c8549d71e10c15fffbc616057e483162a21949644d18d10139e9531' 
            . '3b44ac571052cc0474b59a9540dd';
        
        $results['salt'] = strlen($this->__makeSalt());
        
        $results['password'] = $this->__hashPassword('aBC%123#', $salt);
        
        return $results;
    }
    
}
?>
