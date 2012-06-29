<?php
/**
 * Provides a generic location for basic admin functionality
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
 * @package 42viral\Admin
 */

App::uses('AppController', 'Controller');
/**
 * Provides a generic location for basic admin functionality
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral\Admin
 */
 class AdminController extends AppController {

   /**
    * Name
    * @var string
    * @access public
    */
    public $name = 'Admin';

   /**
    * Uses
    * @var array
    * @access public
    */
    public $uses = array();

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
     * The default admin landing page
     *
     * @access public
     */
    public function admin_index()
    {
        $this->set('title_for_layout', 'Admin Panel');
    }
}
