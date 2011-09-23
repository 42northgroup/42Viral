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
class InboxNotificationAbstract extends AppModel
{

/**
 *
 * @var string
 * @access public
 */
    public $name = 'InboxNotification';

    public $useTable = 'inbox_notifications';


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
 * Add a generated notification to a given person's notification inbox
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @access public
 * @param string $personId
 * @param array $notification
 * @return 
 */
    public function addPersonInboxNotification($personId, $notification)
    {

        if(true) {
            //throw new CakeException('Invalid Notification Object');
        } else {
            $tempInboxNotification = array();
            $tempInboxNotification['subject'] = $notification['subject'];
            $tempInboxNotification['body'] = $notification['body'];
            $tempInboxNotification['notification_email'] = $notification['recipient'];
            $tempInboxNotification['owner_person_id'] = $personId;

            $this->create();
            $saveStatus = $this->save($tempInboxNotification);

            if($saveStatus) {
                return true;
            } else {
                return false;
            }
        }
    }
}