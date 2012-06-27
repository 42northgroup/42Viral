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
/**
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral\Uploads
 */
 class UploadsController extends AppController {

    /**
     * Controller name
     * @var string
     * @access public
     */
    public $name = 'Uploads';

    /**
     * Models this controller uses
     * @var array
     * @access public
     */
    public $uses = array(
        'Upload'
    );

    /**
     * beforeFilter
     *
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->auth(array('*'));
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
        if($this->Upload->process($this->data)){

        }else{
            $this->Session->setFlash(__('The file could not be uploaded'), 'error');
        }
        $this->set('title_for_layout', 'Uploads');
    }
}