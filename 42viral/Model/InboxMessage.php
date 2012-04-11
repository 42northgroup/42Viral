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

App::uses('AppModel', 'Model');
/**
 * Manage person notification inbox
 *
 * @package app
 * @subpackage app.core
 *
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 */
class InboxMessage extends AppModel
{

/**
 * @access public
 * @var string
 */
    public $name = 'InboxMessage';

/**
 * @access public
 * @var string
 */
    public $useTable = 'inbox_messages';

/**
 * @access public
 * @var array
 */
    public $actsAs = array(
        'Log'
    );

/**
 * @access private
 * @var type
 */
    private $__fetchedMessage = null; //cache to store a single fetched message


/**
 * Verify if the passed notification object matches the requirements for being placed in the inbox message
 *
 * @access public
 * @param array $notification
 * @return boolean
 */
    private function __verifyNotificationObject($notification)
    {
        //[TODO] logic to verify notification object here

        return true;
    }


/**
 * Add a generated notification to a given person's message inbox
 *
 * @access public
 * @param string $personId
 * @param array $notification
 * @return boolean
 */
    public function addPersonInboxMessage($personId, $notification)
    {

        $tempMessage = array();
        $tempMessage['subject'] = $notification['subject'];
        $tempMessage['body'] = $notification['body'];
        $tempMessage['notification_email'] = $notification['recipient_email'];
        $tempMessage['owner_person_id'] = $personId;

        $this->create();
        $saveStatus = $this->save($tempMessage);

        if($saveStatus) {
            return true;
        } else {
            return false;
        }
    }


/**
 * Fetch all inbox messages (unarchived and undeleted) of a given user
 *
 * @access public
 * @param string $userId
 * @return array
 */
    public function fetchAllUserInboxMessages($userId)
    {
        $allMessages = $this->find('all', array(
            'contain' => array(),

            'conditions' => array(
                'InboxMessage.owner_person_id' => $userId,
                'InboxMessage.archived' => false,

                'OR' => array(
                    'InboxMessage.deleted' => false,
                    'InboxMessage.deleted IS NULL',
                )
            ),

            'order' => array(
                'InboxMessage.created DESC'
            )
        ));

        return $allMessages;
    }


/**
 * Fetch all messages (including archived) of a given user
 *
 * @access public
 * @param string $userId
 * @return array
 */
    public function fetchAllUserMessages($userId)
    {
        $allMessages = $this->find('all', array(
            'contain' => array(),

            'conditions' => array(
                'InboxMessage.owner_person_id' => $userId,

                'OR' => array(
                    'InboxMessage.deleted' => false,
                    'InboxMessage.deleted IS NULL',
                )
            ),

            'order' => array(
                'InboxMessage.created DESC'
            )
        ));

        return $allMessages;
    }


/**
 * Fetch a single message given the message id
 *
 * @access public
 * @param string $messageId
 * @return InboxMessage
 */
    public function fetchMessage($messageId)
    {
        $message = $this->find('first', array(
            'contain' => array(),

            'conditions' => array(
                'InboxMessage.id' => $messageId
            )
        ));

        $this->__fetchedMessage = $message; //Cache a fetched message in case it is required in another method

        return $message;
    }

/**
 * Verify if a given message really belongs to a given person id
 * (to prevent accidental viewing of someone else's messages by only supplying a message id)
 *
 * @access public
 * @param string $messageId
 * @param string $checkAgainstOwnerId
 * @return boolean
 */
    public function verifyMessageOwnership($messageId, $checkAgainstOwnerId)
    {
        $message = null;

        if(
            ($this->__fetchedMessage !== null) &&
            ($this->__fetchedMessage['InboxMessage']['id'] == $messageId)
        ) {
            $message = $this->__fetchedMessage;
        } else {
            $message = $this->fetchMessage($messageId);
        }

        if($message['InboxMessage']['owner_person_id'] === $checkAgainstOwnerId) {
            return true;
        } else {
            return false;
        }
    }


/**
 * Mark a given message as unread
 *
 * @access public
 * @param string $messageId
 *
 */
    public function markAsUnread($messageId)
    {
        $tempMessage = array();
        $tempMessage['id'] = $messageId;
        $tempMessage['read'] = false;

        if($this->save($tempMessage)) {
            return true;
        } else {
            return false;
        }
    }


/**
 * Mark a given message as read
 *
 * @access public
 * @param string $messageId
 * 
 */
    public function markAsRead($messageId)
    {
        $tempMessage = array();
        $tempMessage['id'] = $messageId;
        $tempMessage['read'] = true;

        if($this->save($tempMessage)) {
            return true;
        } else {
            return false;
        }
    }


/**
 * Mark a given message as archived
 *
 * @access public
 * @param string $messageId
 * @return boolean
 */
    public function archiveMessage($messageId)
    {
        $tempMessage = array();
        $tempMessage['id'] = $messageId;
        $tempMessage['archived'] = true;

        if($this->save($tempMessage)) {
            return true;
        } else {
            return false;
        }
    }


/**
 * Mark a given message as unarchived
 *
 * @access public
 * @param string $messageId
 * @return boolean
 */
    public function unarchiveMessage($messageId)
    {
        $tempMessage = array();
        $tempMessage['id'] = $messageId;
        $tempMessage['archived'] = false;

        if($this->save($tempMessage)) {
            return true;
        } else {
            return false;
        }
    }


/**
 * Mark a given message as deleted (soft delete)
 *
 * @access public
 * @param string $messageId
 * @return boolean
 */
    public function deleteMessage($messageId)
    {
        $tempMessage = array();
        $tempMessage['id'] = $messageId;
        $tempMessage['deleted'] = true;

        if($this->save($tempMessage)) {
            return true;
        } else {
            return false;
        }
    }


/**
 * Returns a given person's count of unread inbox notifications
 *
 * @access public
 * @param string $personId
 * @return integer
 */
    public function findPersonUnreadMessageCount($personId)
    {
        $unreadCount = $this->find('count', array(
            'contain' => array(),

            'conditions' => array(
                'InboxMessage.owner_person_id' => $personId,
                'InboxMessage.read' => false
            )
        ));
        
        return $unreadCount;
    }
}
