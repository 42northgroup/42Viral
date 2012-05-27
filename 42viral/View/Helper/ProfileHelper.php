<?php
/**
 * A class for dealing with user profile data at the UI level
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package 42viral\Person\User\Profile
 */

App::uses('AppHelper', 'View/Helper');
App::uses('HtmlHelper', 'Helper');
/**
 * A class for dealing with user profile data at the UI level
 * @author Jason D Snider <jsnider77@gmail.com>
 * @package 42viral\Person\User\Profile
 */
class ProfileHelper extends AppHelper
{

    /**
     * Import some helpers
     * @var array
     * @access public 
     */
    public $helpers = array('Html');

    /**
     * Determines the best avatar to use for a target user
     * If the user hasn't uploaded a profile this will fall back to gravatar
     * @param array $data
     * @param $size size of the image we are using for avatar
     * @return string
     * @access public
     */
    public function avatar($data, $size = null)
    {
        
        $displayName = $this->name($data);
        
        if(is_null($size)){
            $size = IMAGE_THUMB_DIM_2;
        }
        
        extract($data);

        $avatarPath = IMAGE_WRITE_PATH . $id . DS . 'avatar';

        if (is_dir($avatarPath)) {
            //Scan the avatar directory for an avatar having been set
            foreach (scandir($avatarPath) as $key => $value) {
                if (is_file($avatarPath . DS . $value)) {
                    $avatar = $value;
                    break;
                } else {
                    $avatar = false;
                }
            }
        } else {
            $avatar = false;
        }

        //Has the user picked an uploaded image as an avatar?
        if ($avatar) {
            //Yes, use it
            return $this->Html->image(
                IMAGE_READ_PATH . $id . DS . 'avatar' . DS . $avatar,
                array('width' => $size, 'class'=>'photo')
            );
        } else {
            //No, fallback to gravatar
            
            //Adjust for auto-sizing
            $resize = ($size == '100%')?'512px':$size;
            
            return $this->Html->image(
                'https://secure.gravatar.com/avatar/' . md5(strtolower(trim($email))) . "?r=pg&amp;s={$resize}",
                        array(
                            'style'=>($size == '100%'?"width:100%;":''),
                            'alt'=>$displayName,
                            'title'=>$displayName, 
                            'class'=>'photo')
            );
        }
    }

    /**
     * This will allow a user to choose the name they want to display.
     * @param array $data
     * @return string
     * @access public
     */
    public function displayName($data)
    {
        extract($data);

        //Currently this is just looking to see if you have entered your name.
        if (strlen(trim($name)) == 0) {
            return $this->Html->link($username, $url, array('title'=>$username, 'class'=>'fn'));
        } else {
            return $this->Html->link($name, $url, array('title'=>$name, 'class'=>'fn'));
        }
    }
    

    /**
     * Returns a person name, if the name is empty then this will return the username
     * @param array $data
     * @return string
     * @access public
     */
    public function name($data)
    {
        extract($data);

        //Currently this is just looking to see if you have entered your name.
        if (strlen(trim($name)) == 0) {
            return $username;
        } else {
            return $name;
        }
    }    

}