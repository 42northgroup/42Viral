<?php
/**
 * Deals with uploads from an image point of view
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
 * @package 42viral\Upload\Image
 */

App::uses('AppModel', 'Model');
App::uses('Upload', 'Model');
App::uses('UploadInterface', 'Model');
/**
 * Deals with uploads from an image point of view
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral\Upload\Image
 */
class Image extends Upload
{

    /**
     * The static name of the image object
     * @var string
     * @access public
     */
    public $name = 'Image';

    /**
     * Inject all "finds" against the image object with image filtering criteria
     * @access public
     * @param array $queryData Holds the conditions used to build the CakePHP query
     * @return array 
     */
    public function beforeFind($queryData) {
        parent::beforeFind($queryData);
        
        $queryData['conditions'] = !empty($queryData['conditions']) ? $queryData['conditions'] : array();
        $imageFilter = array('Image.object_type' => 'img');        
        $queryData['conditions'] = array_merge($queryData['conditions'], $imageFilter);

        return $queryData;
    }

    /**
     * Sets a new profile image by writing any image under a users controll to profile.png.
     * Returns true if the operation was successful.
     * @access public
     * @param string $path The path to the desired file
     * @param string $personId The id of the user whos profile is being set
     * @return boolean 
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

    /**
     * Removes the current avatar for a given user
     * @access public
     * @param string $personId The id of the given user
     * @return boolean 
     */
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