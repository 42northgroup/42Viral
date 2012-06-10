<?php
/**
 * Provides controll logic for managing user profile actions
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
 * Provides controll logic for managing user profile actions
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
        'Connect.Facebook', 
        'Connect.Linkedin', 
        'Connect.Tweet',
        'Connect.GooglePlus',
        'Connect.Oauth',
        'Content',
        'Image',         
        'Profile', 
        'Person', 
        'PersonDetail',         
        'SocialNetwork',
        'User'
    );
    
    /**
     * Components
     * @var array
     * @access public 
     */
    public $components = array('Connect.Oauths');
    
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
        $users = $this->User->find('all', array('conditions'=>array(), 'contain'=>array('Profile')));
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
        
        $this->data = $this->Profile->getProfileWith($profileId, 'person'); 
        
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
        
        $addresses = $this->Address->find('all', array(
            'conditions' => array(
                'Address.model_id' => $userProfile['Person']['id'],
                'Address.model' => 'Person'
            ),
            'contain' => array()
        ));
        $this->set('addresses', $addresses);
        
        $this->set('mine', true);
        
        $this->set('title_for_layout', 'Edit Profile');
    }


    /**
     * Action to save profile data submitted through the edit form
     * 
     *
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
     *
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
     *
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
     * Delete person's detail
     * 
     * @access public
     * @param  string $detailId
     *
     */
    public function delete_person_detail($detailId){
        if($this->PersonDetail->delete($detailId)){
            $this->Session->setFlash(__('Detail was deleted successfuly'), 'success');
        }else{
            $this->Session->setFlash(__('Detail could not be deleted'), 'error');
        }
        
        $this->redirect($this->referer());
    }
    
    /**
     * Delete person's address
     * 
     * @access public
     * @param  string $addressId
     *
     */
    public function delete_person_address($addressId){
        if($this->Address->delete($addressId)){
            $this->Session->setFlash(__('Address was deleted successfuly'), 'success');
        }else{
            $this->Session->setFlash(__('Address could not be deleted'), 'error');
        }
        
        $this->redirect($this->referer());
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

        //Get the user data
        $user = $this->User->getUserWith($token, 'full_profile');
        
        //If we found the target blog, retrive an paginate its' posts
        $this->paginate = array(
            'conditions' => array(
                'Content.status'=>array('archived', 'published')
            ),
            'fields'=>array(
                'Content.body', 
                'Content.object_type', 
                'Content.slug', 
                'Content.title', 
                'Content.url'
            ),
            'limit' => 10,
            'order'=>'Content.title ASC'
        );

        $contents = $this->paginate('Content');
        
        //Does the user really exist?
        if(empty($user)) {
            $this->Session->setFlash(__('An invalid profile was requested') ,'error');
            throw new NotFoundException('An invalid profile was requested');
        }

        // Mine
        if($this->Session->read('Auth.User.username') == $token){
            $this->set('mine', true);
        }else{
            $this->set('mine', false);
        }
        
        $this->set('user', $user);
        
        $person = array();
        $person['Person'] = $user['User'];
        
        $userProfile = array();
        $userProfile = array_replace($user, $person);
        unset($userProfile['User']);
        
        $this->set('networks', $this->SocialNetwork->getSocialNetworks());
        $this->set('contents', $contents);
        $this->set('userProfile', $userProfile);
        $this->set('profileId', $userProfile['Profile']['id']);
        $this->set('title_for_layout', ProfileUtil::name($userProfile['Person']) . "'s Profile");

    }
    
    /**
     * Makes sure the all of the user's social media token are available and have not expired. If any of these tokens
     * are unavailable or expired, renews them or if it has to, it reauthenticates the user with the social medias. 
     * once all the tokens are up to date, it the function the the user's statuses.
     *
     * @access public
     * @param string $redirect_url if the function needs reathenticate the user with some social media this parameter 
     *        tell's it where to return after the user hass been reauthenticated
     * @return boolean 
     */
    public function social_media($redirect_url='profiles/social_media')
    {
        
        if( !$this->Session->check('Auth.User.sm_list') ){
            
            $sm_list = $this->Oauth->find('list', array(
                'conditions' => array('Oauth.person_id' => $this->Session->read('Auth.User.id')),
                'fields' => array('Oauth.oauth_id', 'Oauth.service')
            ));

            $this->Session->write('Auth.User.sm_list', $sm_list);
        }
        
        foreach( $this->Session->read('Auth.User.sm_list') as $key => $val ){
            switch ($val){
                
                case 'facebook':
                    if( !$this->Oauths->check_session_for_token('facebook', $redirect_url) ){
                        
                        $this->redirect('/oauth/facebook_connect/');
                    }
                    
                    break;
                
                case 'linked_in':
                    if( !$this->Oauths->check_session_for_token('linked_in', $redirect_url) ){
                        
                        $this->redirect('/oauth/linkedin_connect/');
                    }
                    
                    break;
                case 'twitter':
                    if( !$this->Oauths->check_session_for_token('twitter', $redirect_url) ){
                        
                        $this->redirect('/oauth/twitter_connect/');
                    }
                    
                    break;
                    
                case 'google_plus':
                    if( !$this->Oauths->check_session_for_token('google_plus', $redirect_url) ){
                        
                        $this->redirect('/oauth/google_connect/');
                    }
                    
                    break;
            }
        }
        
        
        
        $sm = $this->Oauth->find('all', array(
            'conditions' => array('Oauth.person_id' => $this->Session->read('Auth.User.id'))            
        ));
        
        $statuses['posts'] = array();
        
        foreach($sm as $media){
            
            switch($media['Oauth']['service']){
                
                case 'facebook':
                    try{
                        
                        $statuses['posts'] = array_merge($statuses['posts'], $this->Facebook->find('all', array(
                            'conditions' => array('oauth_token' => $this->Session->read('Facebook.oauth_token')),
                            'limit'=>5
                        )));
                    }catch(Exception $e){
                        
                        $statuses['connection']['Facebook'] = false;
                    }
                    
                    break;
                
                case 'linked_in':
                    
                    try{
                        
                        $statuses['posts'] = array_merge($statuses['posts'], $this->Linkedin->find('all', array(
                            'conditions' => array(
                                'oauth_token' => $this->Session->read('LinkedIn.oauth_token'),
                                'oauth_token_secret' => $this->Session->read('LinkedIn.oauth_token_secret')
                            ),
                            'limit' => 5
                        )));    
                    }catch(Exception $e){
                        
                        $statuses['connection']['LinkedIn'] = false;
                    }
                    
                    break;
                
                case 'twitter':

                    try{
                        
                        $statuses['posts'] = array_merge($statuses['posts'], $this->Tweet->find('all', array(
                            'conditions' => array('username' => $media['Oauth']['oauth_id']),
                            'limit' => 5
                        )));
                    }catch (Exception $e){
                        
                        $statuses['connection']['Twitter'] = false;
                    }
                    
                    break;
                
                case 'google_plus':

                    try{
                        
                        $statuses['posts'] = array_merge($statuses['posts'], $this->GooglePlus->find('all', array(
                            'conditions' => array(
                                'username' => $media['Oauth']['oauth_id'],
                                'oauth_token' => $this->Session->read('GooglePlus.oauth_token')
                            ),
                            'limit' => 5
                        )));
                    }catch (Exception $e){
                        
                        $statuses['connection']['GooglePlus'] = false;
                    }
                    
                    break;
                            
            }
        }
        
        for($x = 0; $x < count($statuses['posts']); $x++) {
          for($y = 0; $y < count($statuses['posts']); $y++) {
            if($statuses['posts'][$x]['time'] > $statuses['posts'][$y]['time']) {
                $hold = $statuses['posts'][$x];
                $statuses['posts'][$x] = $statuses['posts'][$y];
                $statuses['posts'][$y] = $hold;
            }
          }
        }
        
        return $statuses;
    }
    
}