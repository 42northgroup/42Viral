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
 * Generic user profile object
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
abstract class ProfilesAbstractController extends AppController {

    /**
     * Controller name
     * @var string
     * @access public
     */
    public $name = 'Profiles';


    /**
     * Action to provide a form for editing profile data and pre-loading the form with previously saved data
     *
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access public
     */
    public function edit($profileId) {
        $this->data = $this->Profile->find('first', array(
            'contain' => array(),
            'conditions' => array(
                'Profile.id' => $profileId
            )
        ));
    }


    /**
     * Action to save profile data submitted through the edit form
     *
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access public
     */
    public function save()
    {
        if(!empty($this->data)) {
            $profileData = $this->data;
            $profileData['Profile']['owner_user_id'] = $this->Session->read('Auth.User.id');

            if($this->Profile->save($profileData)) {
                $this->Session->setFlash(__('Profile saved successfully'), 'success');
            } else {
                $this->Session->setFlash(__('There was a problem saving your profile data'), 'error');
            }
        } else {
            die('Invalid operation requested');
        }

        $this->redirect('/profile/' . $this->Session->read('Auth.User.username'));
    }

    /**
     *
     *
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access public
     */
    public function delete() {}


    /**
     *
     *
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access public
     */
    public function view() {}
}