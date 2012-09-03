<?php
/**
 * Provides controll logic for managing users
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
 * @package       42viral\Person\User
 */

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Provides controll logic for managing users
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral\Person\User
 */
 class UserSettingsController extends AppController
{

    /**
     * Models this controller uses
     * @var array
     * @access public
     */

    public $uses = array(
        'UserSetting'
    );

    /**
     * Components
     * @var array
     * @access public
     */
    public $components = array();

    /**
     * Helpers
     * @var array
     * @access public
     */
    public $helpers = array();

    /**
     * beforeFilter
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();

        $this->auth(array('*'));
    }

    public function index($model, $modelId){

        $this->_validRecord($model, $modelId);

        $this->set('title_for_layout', __('User Settings'));

    }
}