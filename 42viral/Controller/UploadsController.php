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
App::uses('ImageUtil', 'Lib');
App::uses('Member', 'Lib');

/**
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 */
 class UploadsController extends AppController
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
        $this->auth(array('image', 'images'));
    }

    /**
     *
     * @param array
     */
    public function images($token = null)
    {
        // If we have no token, we will use the logged in user.
        if (is_null($token)):
            $token = $this->Session->read('Auth.User.username');
        endif;

        //If the token is still null, just stop
        if (is_null($token)) {
            $this->Session->setFlash(__('An invalid profile was requested'), 'error');
            throw new NotFoundException('An invalid profile was requested');
        }

        //Get the data
        $person = $this->Person->getPersonWith($token, 'upload');

        //Does the user really exist?
        if (empty($person)):
            $this->Session->setFlash(__('An invalid profile was requested'), 'error');
            throw new NotFoundException('An invalid profile was requested');
        endif;

        // Mine
        if ($this->Session->read('Auth.User.username') == $token) {
            $this->set('mine', true);
        } else {
            $this->set('mine', false);
        }

        $this->set('user', $person);
        $this->set('userProfile', $person);
        $this->set('title_for_layout', sprintf(__("%s's Photo Stream"), Member::name($person['Person'])));
        
        
        
        
    }

    /**
     *
     * @param type $id 
     * @access public
     */
    public function image($id)
    {

        $image = $this->Image->find('first', array('conditions' => array('Image.id' => $id)));

        $path = $image['Image']['path'] . $this->Upload->name($image['Image']);

        $this->set('image', $image);

        $this->set('path', $path);

        // Mine
        if ($this->Session->read('Auth.User.id') == $image['Image']['created_person_id']) {
            $this->set('mine', true);
        } else {
            $this->set('mine', false);
        }

        $userProfile = $this->Person->find('first', 
                array('conditions' => array('Person.id' => $image['Image']['created_person_id'])));
        
        $this->set('userProfile', $userProfile);
        
        $imageName = Inflector::humanize($image['Image']['name']);
        $this->set('title_for_layout', sprintf(__('Image Manager (%s)'), $imageName));
    }

    public function crop_image()
    {

        $imageProps = $this->data['Upload'];
        $imageId = $imageProps['image_uuid'];

        $image = $this->Image->find('first', array(
            'conditions' => array(
                'Image.id' => $imageId
            )
                ));

        $path = $image['Image']['path'] . $this->Upload->name($image['Image']);
        $fullImagePath = ROOT . DS . APP_DIR . DS . WEBROOT_DIR . $path;

        $cropper = new ImageUtil($fullImagePath);
        $cropper->freeCrop($imageProps);
        $cropper->saveImage($fullImagePath, 90 /* image quality */);

        $this->redirect('/uploads/image/' . $imageId);
    }

/**
 * Uploads an image to a users profile
 * @return void
 * @access public
 */
    public function image_upload()
    {

        if (!empty($this->data)) {

            if ($this->Image->upload($this->data)) {
                $this->Session->setFlash('Saved!', 'success');
            } else {
                $this->Session->setFlash('Failed!', 'error');
            }

            $this->redirect($this->referer());
        }
        
        $this->set('title_for_layout', __('Upload an Image'));
    }

/**
 * Sets a user's profile image
 * @return void
 * @access public
 */
    public function set_avatar($personId, $imageId)
    {

        $image = $this->Image->find('first', array('conditions' => array('Image.id' => $imageId)));

        $path = IMAGE_WRITE_PATH . $personId . DS . $this->Upload->name($image['Image']);

        $this->Image->setProfileImage($path, $personId);

        $this->redirect($this->referer());
    }


/**
 * Switch to using Gravatar as the source for users avatar
 * 
 * @access public
 * @param string $personId
 * @return void
 */
    public function use_gravatar($personId)
    {
        $this->Image->clearPersonAvatar($personId);

        $this->redirect($this->referer());
    }
    
/**
 * Delete a given image and clear user upload record for the image
 * 
 * @access public
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @param string $personId
 * @param string $imageId
 * @return void
 */
    public function delete($personId, $imageId)
    {

        $image = $this->Image->find('first', array('conditions' => array('Image.id' => $imageId)));
        $path = IMAGE_WRITE_PATH . $personId . DS . $this->Upload->name($image['Image']);

        $thumbnailPath_1 = 
            IMAGE_WRITE_PATH . $personId .DS. 'thumbnails' .DS. $this->Upload->thumbnailName($image['Image'], 1);

        $thumbnailPath_2 = 
            IMAGE_WRITE_PATH . $personId .DS. 'thumbnails' .DS. $this->Upload->thumbnailName($image['Image'], 2);

        $this->Upload->delete($imageId);
        
        if(file_exists($path)) {
            unlink($path);
        }

        if(file_exists($thumbnailPath_1)) {
            unlink($thumbnailPath_1);
        }

        if(file_exists($thumbnailPath_2)) {
            unlink($thumbnailPath_2);
        }
        
        $this->redirect('/uploads/images');
    }

}
