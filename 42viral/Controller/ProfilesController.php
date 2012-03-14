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
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 */
 class ProfilesController extends AppController {

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
    public $uses = array('Profile', 'Person', 'PersonDetail', 'Address');

    public $test_profile = array(
        'first_name' => 'Lyubomir',
        'last_name' => 'Dimov',
        'home_phone' => '7083344042',
        'work_phone' => '7083345042',
        'address1' => '16 Shiver Dr.',
        'address2' => 'apt# 203',
        'city' => 'Oak Park',
        'state' => 'IL',
        'zip' => '60520',
        'country' => 'United States of America',
        'email' => 'make@believe.com',
        'username' => 'root',
        'id' => '4e27efec-ece0-4a36-baaf-38384bb83359',
        'image_read_path' => '/img/people/4e27efec-ece0-4a36-baaf-38384bb83359',
        'modified' => '2012-03-12 14:00:14'
    );


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
        $this->set('types', $this->PersonDetail->types);
        
        $person_details = $this->PersonDetail->find('all', array(
            'conditions' => array('PersonDetail.person_id' => $userProfile['Person']['id']),
            'contain' => array()
        ));
        
        $this->set('person_details', $person_details);
        
        $this->set('mine', true);
        
        $this->set('title_for_layout', 'Edit Profile');
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
            } else {
                $this->Session->setFlash(__('There was a problem saving your profile data'), 'error');
            }
        } else {
            throw new NotFoundException('Invalid operation requested');
        }

        $this->redirect('/p/' . $this->Session->read('Auth.User.username'));
    }
    
    /**
     * Saves person's additional details
     * 
     * @access public
     * @return void
     */
    public function save_person_details(){
        if(!empty ($this->data)){
            if($this->PersonDetail->save($this->data)){
                $this->Session->setFlash(__('Details saved successfuly'), 'success');
            }else{
                $errors = '<ul>';
                
                foreach($this->PersonDetail->validationErrors as $key => $val){
                    $errors .= "<li>{$this->PersonDetail->validationErrors[$key][0]}</li>";
                }
                $errors .= '</ul>';
                $this->Session->setFlash(__('There was a problem saving your details'.$errors), 'error');
            }
        }
        
        $this->redirect($this->referer());
    }
    
    /**
     * Saves person's address
     * 
     * @access public
     * @return void
     */
    public function save_person_address(){
        if(!empty ($this->data)){
            if($this->Address->save($this->data)){
                $this->Session->setFlash(__('Address saved successfuly'), 'success');
            }else{
                $errors = '<ul>';
                
                foreach($this->Address->validationErrors as $key => $val){
                    $errors .= "<li>{$this->Address->validationErrors[$key][0]}</li>";
                }
                $errors .= '</ul>';
                $this->Session->setFlash(__('There was a problem saving your address'.$errors), 'error');
            }
        }
        
        $this->redirect($this->referer());
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