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
App::uses('UploadAbstract', 'Model');
App::uses('UploadInterface', 'Model');

/**
 * Mangages file uploads
 *
 * @package app
 * @subpackage app.core
 *
 * *** @author Jason D Snider <jason.snider@42viral.org>
 */
class ImageAbstract extends UploadAbstract
{

    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'Image';

    /**
     * Inject all "finds" against the Upload object with image filtering criteria
     * @param array $query
     * @return type 
     * @access public
     */
    public function beforeFind(&$query)
    {
        $query['conditions'] = !empty($query['conditions']) ? $query['conditions'] : array();
        $imageFilter = array('Image.object_type' => 'img');
        $query['conditions'] = array_merge($query['conditions'], $imageFilter);

        return true;
    }

    /**
     * Sets a new profile image by writing any image under a users controll to profile.png
     * @param type $path
     * @return type 
     * @access public
     */
    public function setProfileImage($path, $personId)
    {

        //Make sure the image paths exist
        $this->_writePath($personId);

        //Clear all images out of the avatar directory, we only want a single file in this directory
        $this->clearPersonAvatar($personId);

        //Path to the avatar directory
        $avatarDirectory = IMAGE_WRITE_PATH . DS . $personId . DS . 'avatar';

        

        //Copy the desired file into the avatar directory
        if (copy($path, $avatarDirectory . DS . 'profile.' . strtolower($this->getExt($path)))) {
            return true;
        } else {
            return false;
        }
    }

    public function clearPersonAvatar($personId)
    {
        //Path to the avatar directory
        $avatarDirectory = IMAGE_WRITE_PATH . DS . $personId . DS . 'avatar';

        foreach (scandir($avatarDirectory) as $key => $value) {
            $targetPath = $avatarDirectory . DS . $value;
            if (is_file($targetPath)) {
                unlink($targetPath);
            }
        }
    }

}