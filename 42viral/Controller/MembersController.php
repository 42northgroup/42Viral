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
App::uses('Member', 'Lib');

/**
 *** @author Jason D Snider <jason.snider@42viral.org>
 */
 class MembersController extends AppController {

    /**
     * Controller name
     * @var string
     * @access public
     */
    public $name = 'Members';

    /**
     * This controller does not use a model
     * @var array
     * @access public
     */
    public $uses = array(
        'Conect.Facebook', 
        'Conect.Linkedin', 
        'Connect.Tweet',
        'Connect.GooglePlus',
        'Image', 
        'Oauth', 
        'Person', 
        'User',
        'PersonDetail',
        'Address'
    );


    public $components = array('ProfileProgress', 'Oauths');

    /**
     * @return void
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
     * @return void
     * @access public
     * @todo TestCase
     */
    public function index()
    {
        $users = $this->User->find('all', array('conditions'=>array(), 'contain'=>array('Profile')));
        $this->set('users', $users);
        $this->set('title_for_layout', 'Members');
    }

    /**
     * My profile
     *
     * @param string $finder
     * @return void
     * @access public
     * @todo TestCase
     */
    public function view($token = null)
    {        
        // If we have no token, we will use the logged in user.
        if(is_null($token)) {
            $token = $this->Session->read('Auth.User.username');
        }

        //Get the user data
        $user = $this->User->fetchUserWith($token, 'full_profile');

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
        
        $services = $this->Oauth->find('list', array(
            'conditions' => array('Oauth.person_id' => $user['User']['id']),
            'fields' => array('Oauth.oauth_id', 'Oauth.service')
        ));

        $this->set('statuses', $this->social_media('members/view'));
        
        $this->set('services', $services);
        $this->set('user', $user);
        
        $person = array();
        $person['Person'] = $user['User'];
        
        $userProfile = array();
        $userProfile = array_replace($user, $person);
        unset($userProfile['User']);
        
        $this->set('userProfile', $userProfile);
        $this->set('profileId', $userProfile['Profile']['id']);
        $this->set('title_for_layout', Member::name($userProfile['Person']) . "'s Profile");
    }

    public function social_media($redirect_url='members/social_media')
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