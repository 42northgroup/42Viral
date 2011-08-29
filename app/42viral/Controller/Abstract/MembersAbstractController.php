<?php

App::uses('AppController', 'Controller');

/**
 *
 */
abstract class MembersAbstractController extends AppController {

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
    public $uses = array('Image', 'User');


    public $components = array('ProfileProgress');

    /**
     * @var array
     * @access public
     */
    public $helpers = array('Member');

    /**
     * @return void
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->auth(array('view'));
    }

    /**
     * Provides an index of all system profiles
     *
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     * @todo TestCase
     */
    public function index()
    {
        $this->loadModel('User');
        $users = $this->User->find('all', array('conditions'=>array(), 'contain'=>array()));
        $this->set('users', $users);
    }

    /**
     * My profile
     *
     * @param string $finder
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
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
        //$user = $this->User->getProfile($token);
        $user = $this->User->getUserWith($token, array(
            'Profile', 'Content', 'Upload', 'Company' => array('Address')
        ));

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

    }


    /**
     *
     */
    public function complete_profile()
    {
        $userId = $this->Session->read('Auth.User.id');
        $token = $this->Session->read('Auth.User.username');

        $user = $this->User->getUserWith($token, array(
            'Profile'
        ));

        $overallProgress = $this->ProfileProgress->fetchOverallProfileProgress($userId);
        $this->set('user', $user);

        //debug($overallProgress);
        $this->set('overall_progress', $overallProgress);
    }
}