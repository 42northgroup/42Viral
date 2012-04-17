<?php
/**
 * Additional securitiy methods
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
App::uses('Security','Utility');
App::uses('String','Utility');
/**
 * Additional securitiy methods
 * @package 42viral\Lib
 * @author Jason D Snider <jason.snider@42viral.org>
 */
class Sec 
{

    /**
     * Creates some pseudo random jibberish to be used as a salt value.
     * @access public
     * @static
     * @return string
     * @author Jason D Snider <jason.snider@42viral.org>
     */
    public static function makeSalt()
    {
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
     * @access public
     * @static 
     * @param string $password, The string the user has submitted as their password.
     * @param string $salt, The users unique salt value.
     * @return string
     */
    public static function hashPassword($password, $salt)
    {
        $preHash = Configure::read('Security.salt');
        $preHash .= $salt;
        $preHash .= Security::hash($password, 'sha512', true); 
        
        $hash = Security::hash($preHash, 'sha512', true);
        
        return $hash;
    }    
    
}
