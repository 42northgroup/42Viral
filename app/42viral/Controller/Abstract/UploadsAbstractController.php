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
App::uses('AppController', 'Controller');

/**
 * @package app
 * @subpackage app.core
 * @author Jason D Snider <jsnider77@gmail.com>
 */
abstract class UploadsAbstractController extends AppController
{

    /**
     *
     * @var array
     * @access public
     */
    public $uses = array('Image', 'Person', 'Upload');

    /**
     *
     * @var array
     * @access public
     */
    public $helpers = array('Member', 'Upload');
    
    /**
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->auth();
    }
 
    /**
     *
     * @param array
     */
    public function images($token = null) 
    {
        // If we have no token, we will use the logged in user.
        if(is_null($token)):
            $token = $this->Session->read('Auth.User.username');
        endif;
        
        //If the token is still null, just stop
        if(is_null($token)){
            $this->Session->setFlash(__('An invalid profile was requested') ,'error');
            throw new NotFoundException('An invalid profile was requested');
        }

        //Get the data
        $person = $this->Person->fetchPersonWith($token, array('Profile', 'Upload'));

        //Does the user really exist?
        if(empty($person)):
            $this->Session->setFlash(__('An invalid profile was requested') ,'error');
            throw new NotFoundException('An invalid profile was requested');
        endif;

        // Mine
        if($this->Session->read('Auth.User.username') == $token){
            $this->set('mine', true);
        }else{
            $this->set('mine', false);
        }

        $this->set('user', $person);
        $this->set('userProfile', $person);
    }
    

    /**
     * Uploads an image to a users profile
     * @return void
     * @access public
     */
    public function image_upload(){

        if(!empty($this->data)){

            if($this->Image->upload($this->data)){
                $this->Session->setFlash('Saved!', 'success');
            }else{
                $this->Session->setFlash('Failed!', 'error');
            }
            
            $this->redirect($this->referer());
        }

    }  

    /**
     * Sets a user's profile image
     * @return void
     * @access public
     */
    public function set_avatar($personId, $imageId){

        $image = $this->Image->find('first', array('conditions'=>array('Image.id'=>$imageId)));
        
        $path = IMAGE_WRITE_PATH . $personId . DS . $this->Upload->name($image['Image']);

        $this->Image->setProfileImage($path, $personId);

        $this->redirect($this->referer());
    }

}
