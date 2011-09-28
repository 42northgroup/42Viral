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
 * @author Zubin Khavarian <zubin.khavarian@42viral.org>
 * @author Jason D Snider <jason.snider@42viral.org>
 */
abstract class ProfilesAbstractController extends AppController {

    /**
     * Controller name
     * @var string
     * @access public
     */
    public $name = 'Profiles';

    /**
     *
     * @var array
     * @access public 
     */
    public $components = array('ProfileProgress');

    /**
     *
     * @var array
     * @access public 
     */
    public $uses = array('Profile', 'Person');

    /**
     * Action to provide a form for editing profile data and pre-loading the form with previously saved data
     *
     * @return void
     * @access public
     */
    public function edit($profileId) {
        
        $this->data = $this->Profile->fetchProfileWith($profileId, 'person'); 

        /* Restructure the Profile data to fit the the userProfile hook */
        $userProfile = array();
        $userProfile['Person'] = $this->data['Person'];
        $userProfile['Person']['Profile'] = $this->data['Profile'];

        $this->set('userProfile', $userProfile);
        
        $this->set('mine', true);
        
    }


    /**
     * Action to save profile data submitted through the edit form
     * 
     * @return void
     * @access public
     */
    public function save()
    {
        if(!empty($this->data)) {
            $profileData = $this->data;

            if($this->Person->saveAll($profileData)) {
                $this->Session->setFlash(__('User Profile saved successfully'), 'success');

                $userId = $this->Session->read('Auth.User.id');
                $overallProgress = $this->ProfileProgress->fetchOverallProfileProgress($userId);
                if($overallProgress['_all'] < 100) {
                    $this->redirect('/members/complete_profile');
                }

            } else {
                $this->Session->setFlash(__('There was a problem saving your profile data'), 'error');
            }
        } else {
            throw new NotFoundException('Invalid operation requested');
        }

        $this->redirect('/profile/' . $this->Session->read('Auth.User.username'));
    }

    /**
     *
     * @access public
     */
    public function delete() {}


    /**
     *
     * @access public
     */
    public function view() {}
}