<?php
/**
 * Allows a user of the system to manage his/her profile
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package       42viral\Person\User\Profile
 */

App::uses('AppController', 'Controller');
App::uses('ProfileUtil', 'Lib');
/**
 * Allows a user of the system to manage his/her profile
 *
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 * @package 42viral\Person\User\Profile
 */
 class ProfilesController extends AppController {

    /**
     * Controller name
     * @var string
     * @access public
     */
    public $name = 'Profiles';

    /**
     * Models this controller uses
     * @var array
     * @access public
     */
    public $uses = array(
        'Address',
        'EmailAddress',
        'Profile',
        'Person',
        'PhoneNumber',
        'SocialNetwork',
        'User'
    );

    /**
     * Components
     * @var array
     * @access public
     */
    public $components = array('Oauths');

    /**
     * beforeFilter
     *
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->auth(array('index', 'view'));
    }

    /**
     * Provides an index of all system profiles
     *
     *
     * @access public
     * @todo TestCase
     */
    public function index()
    {
        $users = $this->User->find(
            'all',
            array(
                'conditions'=>array(
                    'User.access' => array('public')
                ),
                'contain'=>array('Profile')
            )
        );
        $this->set('users', $users);
        $this->set('title_for_layout', 'Profiles');
    }

    /**
     * Action to provide a form for editing profile data and pre-loading the form with previously saved data
     *
     * @access public
     * @param string $profileId provides a unique ID base on which we can find the user's profile
     *
     */
    public function edit($profileId) {

        $this->_validRecord('Profile', $profileId);
        $this->_mine($profileId, 'Auth.User.Profile.id');

        if(!empty($this->data)){
            if($this->Profile->saveAll($this->data)){
                $this->Session->setFlash(__('Your profile has been updated'), 'success');
            }else{
                $this->Session->setFlash(__('Your profile has been updated'), 'serror');
            }
        }

        $this->data = $this->Profile->find(
            'first',
            array(
    			'conditions' => array(
    			    'Profile.id' => $profileId
    		    ),
    			'contain' =>    array(
                    'Person' => array()
                )
            )
        );

        /* Restructure the Profile data to fit the the userProfile hook */
        $userProfile = array();
        $userProfile['Person'] = $this->data['Person'];
        $userProfile['Person']['Profile'] = $this->data['Profile'];

        $this->set('userProfile', $userProfile);
        $this->set('title_for_layout', 'Edit Profile');
    }

    /**
     * Retrives and displays a user's profile
     *
     * @access public
     * @param string $token the unique identifier which we use to retrieve a user profile
     */
    public function view($token = null)
    {
        // If we have no token, we will use the logged in user.
        if(is_null($token)) {
            $token = $this->Session->read('Auth.User.username');
        }

        $this->_validRecord('Person', $token, 'username');

        //Get the user data
        $user = $this->User->find('first', array(
            'conditions'=>array('or' => array(
                'User.id' => $token,
                'User.username' => $token,
                'User.email' => $token
            )),
            'contain' =>    array(
                'Address'=>array(),
                'EmailAddress'=>array(
                    'conditions'=>array(
                        'EmailAddress.access'=>'public'
                    )
                ),
                'PhoneNumber'=>array(
                    'conditions'=>array(
                        'PhoneNumber.access'=>'public'
                    )
                ),
                'Profile'=>array('SocialNetwork'),
                'UserSetting'=>array()
            )
        ));

        // Mine
        if($this->Session->read('Auth.User.username') == $token){
            $this->set('mine', true);
        }else{
            $this->set('mine', false);
        }

        $person = $this->Person->find(
            'first',
             array(
                 'conditions'=>array(
                     'Person.username'=>$token
                 ),
                 'fields'=>array(
                     'Person.id',
                     'Person.name',
                     'Person.username',
                     'Person.url',
                     'Person.email'
                 ),
                'contain'=>array(
                    'Address'=>array(
                        'fields'=>array(
                            'Address.label',
                            'Address.line1',
                            'Address.line2',
                            'Address.city',
                            'Address.state',
                            'Address.zip',
                            'Address.country'
                        ),
                        'conditions'=>array(
                            'Address.access'=>'public'
                        )
                    ),
                    'EmailAddress'=>array(
                        'fields'=>array(
                            'EmailAddress.label',
                            'EmailAddress.email_address'
                         ),
                        'conditions'=>array(
                            'EmailAddress.access'=>'public'
                        )
                    ),
                    'Profile'=>array(
                        'fields'=>array(
                            'Profile.id',
                            'Profile.bio'
                        )
                    ),
                    'PhoneNumber'=>array(
                        'fields'=>array(
                            'PhoneNumber.label',
                            'PhoneNumber.phone_number'
                        ),
                        'conditions'=>array(
                            'PhoneNumber.access'=>'public'
                        )
                    ),
                    'SocialNetwork'=>array(
                         'fields'=>array(
                            'SocialNetwork.network',
                            'SocialNetwork.profile_url'
                        )
                    )
                )
             )
        );

        $this->set('person', $person);
        $this->set('networks', $this->SocialNetwork->getSocialNetworks());
        $this->set('profileId', $person['Profile']['id']);
        $this->set('title_for_layout', ProfileUtil::name($person['Person']) . "'s Profile");

    }

}