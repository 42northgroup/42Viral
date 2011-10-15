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
 class InboxMessageController extends AppController
{
    public $uses = array('InboxMessage');

/**
 * Default action for message inbox (to view a list of all messages for the currently logged in user)
 *
 * @return void
 * @access public
 * @@author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
    public function index()
    {
        $userId = $this->Session->read('Auth.User.id');
        $allMessages = $this->InboxMessage->fetchAllUserInboxMessages($userId);
        $this->set('all_messages', $allMessages);


    }


/**
 * Action to view a single given message
 *
 * @access public
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @param string $messageId
 * @return void
 */
    public function view($messageId)
    {
        $userId = $this->Session->read('Auth.User.id');
        $inboxMessage = $this->InboxMessage->fetchMessage($messageId);
        $verifiedMessageOwner = $this->InboxMessage->verifyMessageOwnership($messageId, $userId);
        
        if($verifiedMessageOwner) {
            $this->InboxMessage->markAsRead($messageId);
            //$this->InboxMessage->markAsUnread($messageId);
            $this->set('inbox_message', $inboxMessage);
        } else {
            $this->set('inbox_message', null);
        }
    }


/**
 * Action to be used for archiving individual messages
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @access public
 * @param string $messageId
 */
    public function archive($messageId)
    {
        $userId = $this->Session->read('Auth.User.id');
        $verifiedMessageOwner = $this->InboxMessage->verifyMessageOwnership($messageId, $userId);

        if($verifiedMessageOwner) {
            $this->InboxMessage->archiveMessage($messageId);
            $this->Session->setFlash('Message archived', 'success');
        } else {
            $this->Session->setFlash('There was a problem archiving the message', 'error');
        }

        $this->redirect('/inbox_message/');
    }

/**
 * 
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @access public
 */
    public function all_messages()
    {
        $userId = $this->Session->read('Auth.User.id');
        $allMessages = $this->InboxMessage->fetchAllUserMessages($userId);
        $this->set('all_messages', $allMessages);
    }


/**
 * Action to be used for soft deleting individual messages
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @access public
 * @param string $messageId
 */
    public function delete($messageId)
    {
        $userId = $this->Session->read('Auth.User.id');
        $verifiedMessageOwner = $this->InboxMessage->verifyMessageOwnership($messageId, $userId);

        if($verifiedMessageOwner) {
            $this->InboxMessage->deleteMessage($messageId);
            $this->Session->setFlash('Message deleted', 'success');
        } else {
            $this->Session->setFlash('There was a problem deleting the message', 'error');
        }

        $this->redirect('/inbox_message/');
    }


/**
 * Temporary action to populate the currently logged in user's message inbox with dummy messages
 * 
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @access public
 */
    public function populate_inbox()
    {
        $userId = $this->Session->read('Auth.User.id');

        $notification = array();
        $notification['subject'] = md5(rand(100, 999)) . ': 42 Viral Message Subject';
        $notification['body'] = 
            'This is just a test message to populate the 42 Viral Message system inbox for the current user';
        $notification['recipient'] = 'test@42viral.org';
        
        $this->InboxMessage->addPersonInboxMessage($userId, $notification);

        $this->redirect('/inbox_message/');
    }

}
