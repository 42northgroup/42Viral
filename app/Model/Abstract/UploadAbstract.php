<?php
App::uses('AppModel', 'Model');
App::uses('File','Utility');
        
/**
 * Mangages file uploads
 * @package App
 * @subpackage App.core
 */
abstract class UploadAbstract extends AppModel
{
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'Upload';
    
    /**
     * 
     * @var string
     * @access public
     */
    public $alias = 'Upload';
    
    
    public $whitelist = array(
      'jpg' => array('image/jpeg', 'image/pjpeg'),
      'jpeg' => array('image/jpeg', 'image/pjpeg'), 
      'gif' => 'image/gif',
      'png' => array('image/png','image/x-png')
    );
    
    function isAllowable($type, $name){
        
    }
    
    /**
     * 
     * @var array
     * @access public
     */
    public $validate = array(
        'username' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' =>"Please enter username",
                'last' => true
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' =>"This username is already in use",
                'last' => true                
            )         
        ),
    );
    
    /**
     * Builds the file paths for a new user
     * @param string $id 
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public static function userWritePaths($id){

        //Create the users file directory
        if(!is_dir(FILE_WRITE_PATH . DS . $id)){
            mkdir(FILE_WRITE_PATH . DS . $id);
        }
        
        //Create the users image directory
        if(!is_dir(IMAGE_WRITE_PATH . DS . $id)){
            mkdir(IMAGE_WRITE_PATH . DS . $id);
        }
    }
    
}