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
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
class InboxMessageAbstract extends AppModel
{

/**
 *
 * @var string
 * @access public
 */
    public $name = 'InboxMessage';

    public $useTable = 'inbox_messages';


/**
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @access public
 * @param array $notification
 * @return boolean
 */
    private function __verifyNotificationObject($notification)
    {
        return true;
    }


/**
 * Add a generated notification to a given person's message inbox
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @access public
 * @param string $personId
 * @param array $notification
 * @return 
 */
    public function addPersonInboxMessage($personId, $notification)
    {

        $tempMessage = array();
        $tempMessage['subject'] = $notification['subject'];
        $tempMessage['body'] = $notification['body'];
        $tempMessage['notification_email'] = $notification['recipient'];
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
 * 
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @access public
 * @param
 */
    public function fetchMessage($messageId)
    {
        
    }

/**
 * Returns a given person's count of unread inbox notifications
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @access public
 * @param string $personId
 * @return integer
 */
    public function findPersonUnreadMessageCount($personId)
    {
        $unreadCount = $this->find('count', array(
            'contain' => array(),

            'conditions' => array(
                'InboxMessage.read' => false
            )
        ));
        
        return $unreadCount;
    }
}
