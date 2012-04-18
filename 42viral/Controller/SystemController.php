<?php
/**
 * Provides a generic interface for system admin actions
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
 * @package 42viral\Content\Page
 */

App::uses('AppController', 'Controller');
/**
 * Provides a generic interface for system admin actions
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral\Content\Page
 */
 class SystemController extends AppController {

   /**
    * Name
    * @var string
    * @access public
    */
    public $name = 'System';

    /**
     * The default admin landing page
     * @return void
     * @access public
     */
    public function admin_index()
    {
        $this->set('title_for_layout', 'System Admin Panel');
    }
}
