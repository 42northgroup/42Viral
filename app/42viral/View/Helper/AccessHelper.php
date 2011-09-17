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

App::uses('AppHelper', 'View/Helper');

/**
 * A helper for hiding unauthorized access.
 * 
 * @package app
 * @subpackage app.core
 **** @author Jason Snider <jsnider77@gmail.com>
 */
class AccessHelper extends AppHelper
{

    public $helpers = array('Html', 'Session');
        
    /**
     * Uses ACLs and sessions to determine if we should show a link
     * @param string $check
     * @param string $title
     * @param mixed $url
     * @param array $options
     * @param type $confirmMessage
     * @return string
     * @access public
     */
    public function link($check, $title, $url = null, $options = array(), $confirmMessage = false) {
        
        //Has the user been authenticated?
        if($this->Session->check('Auth.User.username')){
            
            $permissions = $this->Session->read('Auth.User.Permissions');
            
            // Rekey the permissions array to make it a bit easier to deal with.
            $p = array();
            foreach($permissions as $key => $value){
                $k = explode('/', $key);
                $p[$k[1]] = $value;
            }

            //Yes, the user has been authenticated. Check the privledges.
            if(isset($p[$check])){
                
                //Is the user authorized to access this?
                if($p[$check] != 1){
                    //No, hide the link
                    return false;
                }else{
                    //Yes, show the link
                    return $this->Html->link($title, $url, $options , $confirmMessage);
                }
            }else{
               //No, hide the link
               //return $this->Html->tag('span', $title, array('title'=>'You can\'t do that')); 
               return false;
            }
        }else{
            //No, the user hasn't been authenticated, hide the link
            return false;
            
        }

    }

    /**
     * Uses ACLs and sessions to determine if we should show a link
     * @param string $check
     * @param string $title
     * @param mixed $url
     * @param array $options
     * @param type $confirmMessage
     * @return string
     * @access public
     */
    public function serviceLink($service, $title, $url = null, $options = array(), 
            $confirmMessage = false) {

        if($this->serviceConfiguration()){
            return $this->Html->link($title, $url, $options , $confirmMessage);
        }else{
            return 'Config Error';
        }


    }
    
    /**
     * Returns false if a given service isn't properly configured
     * @param type $service
     * @param type $configCount 
     * @return boolean
     * @access public
     */
    public function serviceConfiguration($service){
        
        $config = Configure::read();
        
        foreach($config[$service]['Schema'] as $key => $value){
            
            //Does the value exist?
            if(isset($config[$service][$key] )){
                
                //Do we have any validation rules set against the configiuration variable
                if(isset($config[$service]['Schema'][$key]['validate'])){

                    //Yes, loop through the validation rules and look for trouble
                    foreach($config[$service]['Schema'][$key]['validate'] as $rule){

                        //Will the validation fail?
                        if( !Validation::$rule($config[$service][$key]) ){
                            //The validation failed, return false
                           return false;
                        }
                    }
                }

            }else{
                //No, return false
                return false;
            }
        }
        
        return true;
    }
    
}