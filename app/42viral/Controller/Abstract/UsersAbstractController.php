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
     * This controller does not use a model
     *
     * @var array
     * @access public
     */
    public $uses = array('Person', 'User', 'AclGroup');

    public $components = array('ProfileProgress');


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

                        $overallProgress = $this->ProfileProgress->fetchOverallProfileProgress($user['User']['id']);

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
}