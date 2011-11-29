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
 *** @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
 class NotificationController extends AppController
{

    public $uses = array('Person', 'Notification');
    public $components = array('NotificationCmp');


/**
 * Default action for the notification controller
 *
 * @access public
 *** @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
    public function index()
    {
        $notifications = $this->Notification->fetchAllNotifications();
        $this->set('notifications', $notifications);

        $this->set('title_for_layout', 'Notification - List All');
    }


/**
 * 
 *
 * @access public
 *** @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @param string $notificationId
  */
    public function view($notificationId)
    {
        $notification = $this->Notification->fetchNotification($notificationId);
        $this->set('notification', $notification);
        $this->set('title_for_layout', 'Notification - View');
    }


/**
 *
 *
 * @access public
 *** @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
    public function create()
    {
        if(!empty($this->data)) {
            $this->Notification->create();
            $opStatus = $this->Notification->save($this->data);

            if($opStatus) {
                $this->Session->setFlash('Notification saved successfully', 'success');
                $this->redirect('/notification/index');
            } else {
                $this->Session->setFlash('There was a problem saving the notification', 'error');
            }
        }

        $this->set('title_for_layout', 'Notification - Create');
    }


/**
 *
 *
 * @access public
 *** @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
    public function edit($notificationId)
    {
        if(!empty($this->data)) {
            $opStatus = $this->Notification->save($this->data);

            if($opStatus) {
                $this->Session->setFlash('Notification saved successfully', 'success');
                $this->redirect('/notification/index');
            } else {
                $this->Session->setFlash('There was a problem saving the notification', 'error');
            }
        }
        
        $notification = $this->Notification->fetchNotification($notificationId);
        $this->set('notification', $notification);

        $this->data = $notification;
        $this->set('title_for_layout', 'Notification - Edit');
    }


/**
 * 
 *
 * @access public
 *** @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @param type $notificationId
 */
    public function delete($notificationId)
    {
        $opStatus = $this->Notification->deleteNotification($notificationId);

        if($opStatus) {
            $this->Session->setFlash('Notification deleted', 'success');
        } else {
            $this->Session->setFlash('There was a problem deleting the notification', 'error');
        }

        $this->redirect('/notification/index');
    }


/**
 * Action to test working of the notification component
 *
 * @return void
 * @access public
 *** @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
    public function test($notificationHandle='')
    {
        $userId = $this->Session->read('Auth.User.id');
        $person = $this->Person->fetchPersonWith($userId, array(), 'id');

        $additionalObjects = array(
            'ProfileCompany' => array(
                'name' => 'ABC Company',
                'address' => '123 Main St Suite 321, NY 12345'
            )
        );

        if(empty($notificationHandle)) {
            $notificationHandle = 'test_notification';
        }

        $notification = $this->Notification->fetchNotification($notificationHandle);
        if(empty($notification)) {
            $this->Notification->generateDummyTestNotification();
        }

        $this->NotificationCmp->triggerNotification($notificationHandle, $person, $additionalObjects);

        $this->Session->setFlash('Notification was fired', 'success');
        $this->redirect('/notification/index');
    }

}
