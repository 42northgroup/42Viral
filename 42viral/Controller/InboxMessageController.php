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
App::uses('Handy', 'Lib');

/**
 * @package app
 * @subpackage app.core
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 */
class InboxMessageController extends AppController
{
    /**
     *
     * @access public
     * @var type
     */
    public $uses = array('InboxMessage');

    
    /**
     * Default action for message inbox (to view a list of all messages for the currently logged in user)
     *
     * @return void
     * @access public
     */
    public function index()
    {
        $userId = $this->Session->read('Auth.User.id');

        if(isset($this->params['named']['show_archived']) && $this->params['named']['show_archived'] == '1') {
            $messages = $this->InboxMessage->fetchAllUserMessages($userId);
        } else {
            $messages = $this->InboxMessage->fetchAllUserInboxMessages($userId);
        }

        $this->set('messages', $messages);
        $this->set('title_for_layout', 'Inbox messages');
    }

    /**
     * Action to view a single given message
     *
     * @access public
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

        $this->set('title_for_layout', "Inbox message - {$inboxMessage['InboxMessage']['subject']}");
    }

    /**
     * Action to be used for archiving individual messages
     *
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
     * Action to be used for soft deleting individual messages
     *
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
     * @access public
     */
    public function populate_inbox()
    {
        $userId = $this->Session->read('Auth.User.id');

        $notification = array();
        //$notification['subject'] = md5(rand(100, 999)) . ': 42 Viral Message Subject';
        
        //$notification['subject'] = Handy::libsum(50);
        $notification['subject'] = Handy::randomLipsum(10, 'words', 2);

        //$notification['body'] = Handy::lipsum(1000);
        $notification['body'] = Handy::randomLipsum(2, 'paras', 100);
        
        $notification['recipient_email'] = 'test@42viral.org';
        
        $this->InboxMessage->addPersonInboxMessage($userId, $notification);

        $this->redirect('/inbox_message/');
    }
}
