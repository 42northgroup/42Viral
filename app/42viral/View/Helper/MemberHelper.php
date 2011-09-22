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
 * *** @author Jason Snider <jsnider77@gmail.com>
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
     * @author Jason D Snider <jason.snider@42viral.org>
     * @access public
     */
    public function avatar($data, $size = 128)
    {

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
                IMAGE_READ_PATH . $id . DS . 'avatar' . DS . $avatar . '?' .md5(rand(10000, 99999)),
                array('width' => $size)
            );
        } else {
            //No, fallback to gravatar
            return $this->Html->image(
                'https://secure.gravatar.com/avatar/' . md5(strtolower(trim($email))) . "?r=pg&amp;s={$size}"
            );
        }
    }

    /**
     * Determines the best display name to use for a target user
     * @param array $data
     * @return string
     * @author Jason D Snider <jason.snider@42viral.org>
     * @access public
     */
    public function displayName($data)
    {
        extract($data);

        //Currently this is just looking to see if you have entered your name.
        if (strlen(trim($name)) == 0) {
            return $this->Html->link($username, $url);
        } else {
            return $this->Html->link($name, $url);
        }
    }

}