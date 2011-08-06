<?php
App::uses('AppHelper', 'View/Helper');
App::uses('HtmlHelper', 'Helper');

/**
 * A class for dealing with profile/memeber data display
 * 
 * Copyright (c) 2011,  MicroTrain Technologies (http://www.microtrain.net)
 * licensed under MIT (http://www.opensource.org/licenses/mit-license.php)
 *
 * @copyright Copyright 2010, MicroTrain Technologies (http://www.microtrain.net)
 * @package app
 * @subpackage app.core
 * @author Jason Snider <jsnider77@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class MemberHelper extends AppHelper
{
    /**
     *
     * @var array
     * @access public 
     */
    public $helpers = array('Html');
    
    /**
     * Determines the best avatar to use for a target user
     * If the user hasn't uploaded a profile this will fall back to gravatar
     * @param array $data
     * @return string
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function avatar($data){
        
        extract($data);
        
        if(is_file(IMAGE_WRITE_PATH . $id . DS . 'profile.png')){
            return $this->Html->image(IMAGE_READ_PATH . $userId . DS . 'profile.png');
        }else{
            return $this->Html->image(
                'https://secure.gravatar.com/avatar/' . md5( strtolower(trim($email))) . '?r=pg&amp;s=128'
            );
        }
        
    }

    /**
     * Determines the best display name to use for a target user
     * @param array $data
     * @return string
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function displayName($data){
        
        extract($data);
        
        if(strlen(trim($name)) == 0){
            return $username;
        }else{
            return $name;
        }
        
    }
    
}