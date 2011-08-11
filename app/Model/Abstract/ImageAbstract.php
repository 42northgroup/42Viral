<?php
App::uses('UploadAbstract', 'Model');
App::uses('UploadInterface', 'Model');

/**
 * Mangages file uploads
 * @package App
 * @subpackage App.core
 */
abstract class ImageAbstract extends UploadAbstract
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
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function beforeFind(&$query) 
    {
        $query['conditions'] =!empty($query['conditions'])?$query['conditions']:array();
        $imageFilter = array('Image.object_type' =>'img');
        $query['conditions'] =array_merge($query['conditions'], $imageFilter);
        
        return true;
    } 
    
    /**
     * Sets a new profile image by writing any image under a users controll to profile.png
     * @param type $path
     * @return type 
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function setProfileImage($path, $personId){
        
        //Make sure the image paths exist
        $this->_writePath($personId);
        
        //Path to the avatar directory
        $avatarDirectory = IMAGE_WRITE_PATH . DS . $personId . DS . 'avatar';
        
        //Clear all images out of the avatar directory, we only want a single file in this directory
        foreach(scandir($avatarDirectory) as $key => $value){
            $targetPath = $avatarDirectory . DS . $value;
            if(is_file($targetPath)){
                unlink($targetPath);
            }
        }
        
        //Copy the desired file into the avatar directory
        if(copy($path, $avatarDirectory . DS . 'profile.' . $this->getExt($path))){
            return true;
        }else{
            return false;
        }             
    }    
}