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
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
abstract class InboxMessageAbstractController extends AppController
{
    public $uses = array('InboxMessage');

/**
 *
 *
 * @return void
 * @access public
 * @@author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
    public function index() {
        $userId = $this->Session->read('Auth.User.id');
        $unreadCount = $this->InboxMessage->findPersonUnreadMessageCount($userId);
        $this->set('unread_count', $unreadCount);
    }


/**
 *
 *
 * @return void
 * @access public
 * @@author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
    public function view($messageId) {
        $userId = $this->Session->read('Auth.User.id');
        $inboxMessage = $this->InboxMessage->fetchMessage($messageId);
        
        
    }

}
