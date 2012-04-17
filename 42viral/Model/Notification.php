<?php
/**
 * Manage notification template objects
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
 * @package 42viral\Notification
 */

App::uses('AppModel', 'Model');
App::uses('Handy', 'Lib');
/**
 * Manage notification template objects
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @package 42viral\Notification
 */
class Notification extends AppModel
{

    /**
     * The static name of the notification object
     * @var string
     * @access public
     */
    public $name = 'Notification';


    /**
     * Specifies the table to be used by the notification object
     * @var string
     * @access public
     */
    public $useTable = 'notifications';

    /**
     * Specifies the behaviors to be invoked by the notification model
     * @var array
     * @access public
     */
    public $actsAs = array(
        'Log',
        
        'ContentFilters.Scrubable' => array(
            'Filters' => array(
                'trim' => '*',
                //'htmlStrict' => array('body_template'),
                'noHTML' => array('id', 'name', 'alias', 'subject_template'),
            )
        )
    );


    /** 
     * Specifies the validation parameters for the notification model
     * @var array
     * @access public
     */
    public $validate = array(
        'alias' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => "Please enter an alias"
            ),

            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => "Given alias needs to be unique"
            )
        ),

        'name' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => "Please enter an name"
            )
        ),

        'subject_template' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => "Please enter an Subject Template"
            )
        ),

        'body_template' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => "Please enter an Body Template"
            )
        )
    );

    /**
     * Used for generating a dummy test notification for testing purposes
     * @access public
     * @return void
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

    /**
     * Fetch all notifications sorted by their name in ascending order
     * @access public
     * @return array
     */
    public function fetchAllNotifications()
    {
        $notifications = $this->find('all', array(
            'contain' => array(),
            
            'order' => array(
                'Notification.name ASC'
            )
        ));

        return $notifications;
    }

    /**
     * Deletes a single given notification using its ID
     * @access public
     * @param $notificationId
     * @return boolean
     */
    public function deleteNotification($notificationId)
    {
        $opStatus = $this->delete($notificationId);

        return $opStatus;
    }
}