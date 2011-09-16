<?php

App::uses('Security','Utility');
App::uses('String','Utility');

//namespace FortyTwoViral\Lib\Sec;

/**
 * Additional security methods
 *
 * @package app
 * @subpackage app.core
 */
class Sec {

    /**
     * Creates some pseudo random jibberish to be used as a salt value.
     * @return string
     ** @author Jason D Snider <jason.snider@42viral.org>
     * @access public
     */
    public static function makeSalt(){
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
     ** @author Jason D Snider <jason.snider@42viral.org>
     * @access public
     */
    public static function hashPassword($password, $salt){
        $preHash = Configure::read('Security.salt');
        $preHash .= $salt;
        $preHash .= Security::hash($password, 'sha512', true); 
        
        $hash = Security::hash($preHash, 'sha512', true);
        
        return $hash;
    }    
    
}
