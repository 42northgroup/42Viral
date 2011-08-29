<?php

App::uses('AppController', 'Controller');

/**
 * @package app
 * @subpackage app.core
 */
abstract class UploadsAbstractController extends AppController
{

    /**
     *
     * @var array
     * @access public
     */
    public $uses = array('User');

    /**
     *
     * @var array
     * @access public
     */
    public $helpers = array('Member');
    
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
    public function images($token) 
    {
        // If we have no token, we will use the logged in user.
        if(is_null($token)):
            $token = $this->Session->read('Auth.User.username');
        endif;

        //Get the user data
        //$user = $this->User->getProfile($token);
        $user = $this->User->getUserWith($token, array('Profile', 'Upload'));

        //Does the user really exist?
        if(empty($user)):
            $this->Session->setFlash(__('An invalid profile was requested') ,'error');
            throw new NotFoundException('An invalid profile was requested');
        endif;

        // Mine
        if($this->Session->read('Auth.User.username') == $token){
            $this->set('mine', true);
        }else{
            $this->set('mine', false);
        }

        $this->set('user', $user);
    }
    

    /**
     * Uploads an image to a users profile
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function image_upload($personId){

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
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function set_avatar($personId, $imageId){

        $image = $this->Image->find('first', array('conditions'=>array('Image.id'=>$imageId)));

        $path = IMAGE_WRITE_PATH . $personId . DS . $image['Image']['name'];

        $this->Image->setProfileImage($path, $personId);

        $this->redirect($this->referer());
    }

}
