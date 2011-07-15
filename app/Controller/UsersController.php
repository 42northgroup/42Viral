<?php

App::uses('AppController', 'Controller');

/**
 * @package app
 * @subpackage app.core
 */
class UsersController extends AppController {

    /**
     * This controller does not use a model
     *
     * @var array
     * @access public
     */
    public $uses = array();


    /**
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();
        
        $this->Auth->allow('user_add', 'login'); 
    }
    /**
     * The public action for loging into the system
     * 
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
     */
    public function login()
    {
        $error = true;
        if(!empty($this->data)){
            $this->loadModel('User');
            
            $user = $this->User->find('first', 
                        array(
                            'conditions'=>array(
                                'or'=>array(
                                    'User.username'=>$this->data['User']['username'],
                                    'User.email'=>$this->data['User']['username']
                                ),
                            )
                        )
                    );
            
            if(empty($user)){
                $this->log("User not found {$this->data['User']['username']}", 'weekly_user_login');
                $error = true;
            }else{
                
                $hash = Security42::hashPassword($this->data['User']['password'], $user['User']['salt']);
                if($hash == $user['User']['password']){
                    
                    if($this->Auth->login($user)){
                        $this->Session->setFlash('You have been authenticated', 'success');
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
     * 
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
     */
    public function logout()
    {
        $this->Auth->logout();
        $this->redirect('/users/login');
    }
}
