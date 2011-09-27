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
App::uses('Handy', 'Lib');

/**
 * Manage notification template objects
 *
 * @package app
 * @subpackage app.core
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
class NotificationAbstract extends AppModel
{

/**
 * @var string
 * @access public
 */
    public $name = 'Notification';


/**
 * @var string
 * @access public
 */
    public $useTable = 'notifications';


/**
 * Used for generating a dummy test notification for testing purposes
 *
 * @access public
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
    public function generateDummyTestNotification()
    {
        $tempNotification = array();
        $tempNotification['alias'] = 'test_notification';
        $tempNotification['name'] = 'Test Notification';
        $tempNotification['active'] = true;
        $tempNotification['subject_template'] = 'TEST Notification Subject #{Person.first_name}';
        $tempNotification['body_template'] = 'TEST Notification Body #{Person.first_name} #{Person.last_name}';
        $tempNotification['email_template'] = 'notification';

        $this->save($tempNotification);
    }


/**
 * Fetch a notification using a notification handle (id or alias)
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @access public
 * @param string $notificationHandle
 * @return Notification
 */
    public function fetchNotification($notificationHandle)
    {
        if(Handy::isUUID($notificationHandle)) {
            $notification = $this->fetchNotificationById($notificationHandle);
        } else {
            $notification = $this->fetchNotificationByAlias($notificationHandle);
        }

        return $notification;
    }


/**
 * Fetch a notification record using its given id
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @access public
 * @param string $notificationId
 * @return Notification
 */
    public function fetchNotificationById($notificationId)
    {
        $notification = $this->find('first', array(
            'contain' => array(),

            'conditions' => array(
                'Notification.id' => $notificationId
            )
        ));

        return $notification;
    }


/**
 * Fetch a notification record using its given alias
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @access public
 * @param string $alias
 * @return Notification
 */
    public function fetchNotificationByAlias($alias)
    {
        $notification = $this->find('first', array(
            'contain' => array(),

            'conditions' => array(
                'Notification.alias' => $alias
            )
        ));

        return $notification;
    }
}