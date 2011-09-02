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

//App::uses('ProfileAbstract', 'AbstractModel');
//App::uses('CompanyAbstract', 'AbstractModel');
//App::uses('OauthAbstract', 'AbstractModel');

/**
 * @package app
 * @subpackage app.core
 * @author Jason D Snider <jsnider77@gmail.com>
 */
abstract class UsersAbstractController extends AppController
{

    /**
     * @var array
     * @access public
     */

    public $uses = array('Person', 'User', 'AclGroup', 'Tweet', 'Oauth');

    /**
     * @var array
     * @access public
     */
    public $components = array('Access', 'ProfileProgress', 'Oauths');


    /**
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();

        $this->auth(array('create', 'login', 'logout'));

        //Allows us to login against either the username or email
        $this->Auth->fields = array('username' => array('username', 'email'));

        $this->Auth->loginAction = array('admin' => false, 'controller' => 'users', 'action' => 'login');

        $this->Auth->autoRedirect = true;
        $this->Auth->loginRedirect = array('controller' => 'members', 'action' => 'view');
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
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
            $this->loadModel('User');

            $user = $this->User->getUser($this->data['User']['username']);

            if(empty($user)){
                $this->log("User not found {$this->data['User']['username']}", 'weekly_user_login');
                $error = true;
            }else{

                $hash = Sec::hashPassword($this->data['User']['password'], $user['User']['salt']);
                if($hash == $user['User']['password']){

                    if($this->Auth->login($user['User'])){
                        $this->Session->setFlash('You have been authenticated', 'success');

                        $this->Session->write('Auth.User', $user['User']);
                        $this->Access->permissions($user['User']);

                        $overallProgress = $this->ProfileProgress->fetchOverallProfileProgress($user['User']['id']);

                        //If profile progress is less than a 100 percent, direct the user to the complete profile
                        //page after successfull login
                        if($overallProgress['_all'] < 100) {
                            $this->Auth->loginRedirect = array(
                                'controller' => 'members',
                                'action' => 'complete_profile'
                            );
                        }

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

            if($error){
                $this->Session->setFlash('You could not be authenticated', 'error');
            }
        }
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
     * @todo TestCase
     * @todo Complete and harden
     */
    public function create()
    {
        $this->loadModel('User');

        if(!empty($this->data)){

            if($this->User->createUser($this->data['User'])){

                $user = $this->User->findByUsername($this->data['User']['username']);

                $this->Acl->Aro->create(array(
                    'model'=>'User',
                    'foreign_key'=>$user['User']['id'],
                    'alias'=>$user['User']['username'], 0, 0));

                $this->Acl->Aro->save();

                if($this->Auth->login($user)){

                    $this->Session->write('Auth.User', $user['User']);

                    $this->Session->setFlash('Your account has been created and you have been logged in','success');
                    $this->redirect($this->Auth->redirect());
                }else{
                    $this->Session->setFlash('Your account has been created, you may now log in','error');
                    $this->redirect($this->Auth->redirect());
                }

            }else{
                $this->Session->setFlash('Your account could not be created','error');
            }

        }
    }

    public function admin_create_group()
    {

        if(!empty($this->data)){

            if($this->AclGroup->save($this->data['AclGroup'])){

                $acl_group = $this->AclGroup->findByAlias($this->data['AclGroup']['alias']);

                $this->Acl->Aro->create(array(
                    'model'=>'AclGroup',
                    'foreign_key'=>$acl_group['AclGroup']['id'],
                    'alias'=>$acl_group['AclGroup']['alias'], 0, 0));

                $this->Acl->Aro->save();
                
                $this->Acl->Aco->create(array(
                    'model'=>'AclGroup',
                    'parent_id'=>1,
                    'foreign_key'=>$acl_group['AclGroup']['id'],
                    'alias'=>$acl_group['AclGroup']['alias'].'-group'
                    ));

                $this->Acl->Aco->save();

                $this->redirect('/admin/privileges/user_privileges/'.$acl_group['AclGroup']['alias']);
            }else{
                $this->Session->setFlash('Your account could not be created','error');
            }

        }
    }

    public function admin_index()
    {
        $people = $this->Person->find('all');
        $acl_groups = $this->AclGroup->find('all');

        $this->set('acl_groups', $acl_groups);
        $this->set('people', $people);
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
        
    }
    
        
    public function socialize(){
        if(!empty ($this->data)){
            
            if( $this->data['SocialMedia']['twitter_post'] == 1 ){
                
                $this->loadModel('Tweet');
                $this->Tweet->save(array(
                    'status' => $this->data['SocialMedia']['twitter'],
                    'oauth_token' => $this->Session->read('Twitter.oauth_token'),
                    'oauth_token_secret' => $this->Session->read('Twitter.oauth_token_secret')
                ));
            }
            
            if( $this->data['SocialMedia']['linkedin_post'] == 1 ){
                
                $this->loadModel('Linkedin');
                $this->Linkedin->save(array(
                    'status' => $this->data['SocialMedia']['others'],
                    'oauth_token' => $this->Session->read('LinkedIn.oauth_token'),
                    'oauth_token_secret' => $this->Session->read('LinkedIn.oauth_token_secret')
                ));
            }
            
            if( $this->data['SocialMedia']['facebook_post'] == 1 ){
                
                $this->loadModel('Facebook');
                $this->Facebook->save(array(
                    'status' => $this->data['SocialMedia']['others'],
                    'oauth_token' => $this->Session->read('Facebook.oauth_token')
                ));
            }
            
            $this->Session->setFlash('Your social media has been updated', 'success');
            $this->redirect('/users/social_media');
        }
    }
}