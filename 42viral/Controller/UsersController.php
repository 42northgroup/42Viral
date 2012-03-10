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
 * @author Jason D Snider <jason.snider@42viral.org>
 */
 class UsersController extends AppController
{

    /**
     * @var array
     * @access public
     */

    public $uses = array(
        'AclGroup',
        'Conect.Facebook', 
        'Conect.Linkedin', 
        'Connect.Tweet', 
        'Invite', 
        'Oauth', 
        'Person', 
        'User',
        //'Notification'
    );

    /**
     * @var array
     * @access public
     */
    public $components = array(
        'Access', 
        'ControllerList', 
        'ProfileProgress', 
        'Oauths', 
        'NotificationCmp'
    );


    /**
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();

        $this->auth(array('create', 'login', 'logout', 'pass_reset_req', 'pass_reset'));

        //Allows us to login against either the username or email
        $this->Auth->fields = array('username' => array('username', 'email'));

        $this->Auth->autoRedirect = true;
        $this->Auth->loginRedirect = array('controller' => 'members', 'action' => 'view');
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
    }

    /**
     * Action to reset(change) a user's password after a reset token was issued
     *
     * @access public
     * @param string $resetToken
     */
    public function pass_reset($resetToken)
    {
        
        if($this->User->checkPasswordResetTokenIsValid($resetToken)) {
            $user = $this->User->getUserFromResetToken($resetToken);
            $userId = $user['User']['id'];

            if(!empty($this->data)) {
                
                
                $opStatus = $this->User->changePassword($this->data['Person']);

                if($opStatus) {
                    $this->Session->setFlash(
                        __('Your password was changed successfully, try logging in with your new password'),
                        'success'
                    );

                    $this->redirect('/users/login');
                } else {
                    $this->Session->setFlash(__('There was a problem changing your password, try again'), 'error');
                    $this->redirect("/users/pass_reset/{$resetToken}");
                }
            } else {
                $this->set('user_id', $userId);
                $this->set('reset_token', $resetToken);
            }
        } else {
            $this->Session->setFlash(
                __('The password reset request token is invalid or has expired, try generating a new one'),
                'error'
            );

            $this->redirect('/users/pass_reset_req');
        }
        $this->set('title_for_layout', __('Reset Your Password'));
    }

    /**
     *
     *
     * @access public
     */
    public function pass_reset_req()
    {
        $error = true;

        if(!empty($this->data)) {
            $user = $this->User->fetchUserWith($this->data['User']['username']);

            if(empty($user)) {
                $this->log("User not found {$this->data['User']['username']}", 'weekly_user_login');
                $error = true;
            } else {
                $error = false;
                $userId = $user['User']['id'];

                //generate password reset authorization link
                $requestAuthorizationToken = String::uuid();
                $tokenExpiry = date('Y-m-d H:i:s', mktime() + DAY);

                //store password reset authorization link with person record along with expiration timestamp
                $tokenData = array();
                $tokenData['Person']['id'] = $userId;
                $tokenData['Person']['pw_reset_token'] = $requestAuthorizationToken;
                $tokenData['Person']['pw_reset_token_expiry'] = $tokenExpiry; 
                $this->Person->save($tokenData);

                //email the person with the password reset authorization link
                $person = $this->Person->fetchPersonWith($userId, array(), 'id');

                $additionalObjects = array(
                    'reset_authorization_token' => $requestAuthorizationToken
                );

                $notificationHandle = 'password_reset_request';
                $this->NotificationCmp->triggerNotification($notificationHandle, $person, $additionalObjects);


                $this->Session->setFlash(
                    __('Check your email for a password reset authentication link'),
                    'success'
                );
            }

            if($error) {
                $this->Session->setFlash(
                    __('Password reset request failed. Please check the username you entered'),
                    'error'
                );
            }

            $this->redirect('/users/login');
        } else {

        }

        $this->set('title_for_layout', __('Reset Your Password'));
        
    }

    /**
     * The public action for loging into the system
     * @access public
     * @todo TestCase
     */
    public function login()
    {        
        $error = true;
        if(!empty($this->data)){

            $user = $this->User->fetchUserWith($this->data['User']['username'], 'profile', 'username');

            if(empty($user)){
                $this->log("User not found {$this->data['User']['username']}", 'weekly_user_login');
                $error = true;
            }else{

                $hash = Sec::hashPassword($this->data['User']['password'], $user['User']['salt']);
                if($hash == $user['User']['password']){

                    if($this->Auth->login($user['User'])){
                        $this->Session->setFlash(__('You have been authenticated'), 'success');

                        $this->Session->write('Auth.User', $user['User']);
                        $this->Session->write('Auth.User.Profile', $user['Profile']);
                        $this->Access->permissions($user['User']);

                        $overallProgress = $this->ProfileProgress->fetchOverallProfileProgress($user['User']['id']);

                        $this->redirect($this->Auth->redirect());

                        $error = false;
                    }else{
                        $error = true;
                    }

                }else{
                    $this->log("Password mismatch {$this->data['User']['username']}", 'weekly_user_login');
                    $error = true;
                }
            }

            if($error) {
                $this->Session->setFlash(__('You could not be authenticated'), 'error');
            }
        }
        
        $this->set('title_for_layout', __('Login to Your Account'));
    }

    /**
     * The public action for loging out of the system
     * @access public
     * @todo TestCase
     */
    public function logout()
    {
        $this->Auth->logout();
        $this->redirect('/users/login');
    }

    /**
     * Creates a user account using user submitted input
     * Logs the newly created user into the system
     *
     * @return void
     * @access public
     */
    public function create()
    {

        if(!empty($this->data)){
            
            //Private beta, if we are in private beta mode, look for an invite code
            if(Configure::read('Beta.private') == 1){  
                if($this->Invite->confirm($this->data['User']['invite'])){
                    $allowed = true;
                }else{
                    $this->Session->setFlash(__('Their is a problem with the invite code'),'error');
                    $allowed = false;
                }
            }else{
                //Private beta mode is turned off
                $allowed = true;
            }
            
            //If we have a valid code or we are not in private beta, proceed
            if($allowed){
                
                //Is the user data valid?
                if($this->User->createUser($this->data['User'])){

                    //Invalidate the private beta invite token
                    if(Configure::read('Beta.private') == 1){  
                        $this->Invite->accept($this->data['User']['invite']);
                    }
                    
                    
                    //Create the new users ARO entry
                    $this->Acl->Aro->create(array(
                        'model'=>'User',
                        'foreign_key'=>$this->User->id,
                        'parent_id'=>2, 
                        'alias'=>$this->data['User']['username'], 0, 0));

                    $this->Acl->Aro->save();

                    //Update the new users privledges
                    $controllers = $this->ControllerList->get_all();

                    foreach($controllers as $key => $val){
                        foreach($controllers[$key] as $index => $action){

                            $this->Acl->inherit($this->data['User']['username'],$key.'-'.$action,'*');
                        }
                    }

                    //Log the new user into the system
                    $user = $this->User->findByUsername($this->data['User']['username']);

                    if($this->Auth->login($user)){

                        $this->Session->write('Auth.User', $user['User']);
                        $this->Access->permissions($user['User']);

                        $this->Session->setFlash(__('Your account has been created and you have been logged in'),'success');
                        $this->redirect($this->Auth->redirect());
                        
                    }else{
                        
                        $this->Session->setFlash(__('Your account has been created, you may now log in'),'error');
                        $this->redirect($this->Auth->redirect());
                        
                    }

                }else{
                    
                    $this->Session->setFlash(__('Your account could not be created'),'error');
                    
                }
            }
        }
        
        $this->set('title_for_layout', 'Create a New Account');
    }

    public function admin_acl_groups()
    {
        $aclGroups = $this->AclGroup->find('all');
        $this->set('aclGroups', $aclGroups);
        $this->set('title_for_layout', __('ACL ARO Groups'));
    }   
    
    public function admin_create_acl_group()
    {

        if(!empty($this->data)){

            if($this->AclGroup->save($this->data['AclGroup'])){

                $acl_group = $this->AclGroup->findByAlias($this->data['AclGroup']['alias']);

                $this->Acl->Aro->create(array(
                    'model'=>'AclGroup',
                    'foreign_key'=>$acl_group['AclGroup']['id'],
                    'alias'=>$acl_group['AclGroup']['alias'], 0, 0));

                $this->Acl->Aro->save();
                                
                $this->redirect('/admin/privileges/user_privileges/'.$acl_group['AclGroup']['alias']);
            }else{
                $this->Session->setFlash(__('Your account could not be created'),'error');
            }

        }
        
        $this->set('title_for_layout', 'Create an ACL ARO Group');
    }

    public function admin_index()
    {
        $people = $this->Person->find('all');
        $this->set('people', $people);
        $this->set('title_for_layout', __('Everyone in the System'));
    }    
    
    
    public function social_media($redirect_url='users/social_media')
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
                    $this->Oauths->check_session_for_token('facebook', $redirect_url);
                    break;
                
                case 'linked_in':
                    $this->Oauths->check_session_for_token('linked_in', $redirect_url);
                    break;
                case 'twitter':
                    $this->Oauths->check_session_for_token('twitter', $redirect_url);
                    break;
            }
        }
        
        $this->set('title_for_layout', __('Socailize and Share Your Thoughts'));
        
    }
    
        
    public function socialize(){
        if(!empty ($this->data)){
            
            if( $this->data['SocialMedia']['twitter_post'] == 1 ){
                
                $this->Tweet->save(array(
                    'status' => $this->data['SocialMedia']['twitter'],
                    'oauth_token' => $this->Session->read('Twitter.oauth_token'),
                    'oauth_token_secret' => $this->Session->read('Twitter.oauth_token_secret')
                ));
            }
            
            if( $this->data['SocialMedia']['linkedin_post'] == 1 ){
                
                $this->Linkedin->save(array(
                    'status' => $this->data['SocialMedia']['others'],
                    'oauth_token' => $this->Session->read('LinkedIn.oauth_token'),
                    'oauth_token_secret' => $this->Session->read('LinkedIn.oauth_token_secret')
                ));
            }
            
            if( $this->data['SocialMedia']['facebook_post'] == 1 ){
                
                $this->Facebook->save(array(
                    'status' => $this->data['SocialMedia']['others'],
                    'oauth_token' => $this->Session->read('Facebook.oauth_token')
                ));
            }
            
            $this->Session->setFlash(__('Your social media has been updated'), 'success');
            $this->redirect('/users/social_media');
        }
    }
    
    public function settings($token=null)
    {
        // If we have no token, we will use the logged in user.
        if(is_null($token)) {
            $token = $this->Session->read('Auth.User.username');
        }

        //Get the user data
        $user = $this->User->getUserWith($token, array(
            'Profile', 'Content', 'Upload'
        ));

        //Does the user really exist?
        if(empty($user)) {
            $this->Session->setFlash(__('An invalid user was requested') ,'error');
            throw new NotFoundException('An invalid user was requested');
        }             
        
        $this->set('user', $user);
        
        $userProfile['Person'] = $user['User'];
        $this->set('userProfile', $userProfile);
        $this->set('title_for_layout', 'Your Account Settings');
    }
    
    public function change_password()
    {
        if(!empty ($this->data)){
            
            if($this->User->changePassword($this->data['Person'])){
                
                $this->Session->setFlash(__('Password was changed successfully'), 'success');
                $this->redirect('/users/settings');
            }else{
                
                $this->Session->setFlash(__('An error occured, password could not be changed'), 'error');
                $this->redirect('/users/settings');
            }
        }
    }
}