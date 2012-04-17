<?php
/**
 * PHP 5.3
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
 */

App::uses('AppController', 'Controller');
/**
 * @package app
 * @subpackage app.core
 */
 class NotificationController extends AppController
{

     /**
     * Models this controller uses
     * @var array
     * @access public
     */
    public $uses = array('Person', 'Notification');
    
    /**
     * Components 
     *
     * @access public
     * @var array
     */
    public $components = array('NotificationCmp');


    /**
     * Default action for the notification controller
     *
     * @access public
     * @return void
     */
    public function index()
    {
        $notifications = $this->Notification->fetchAllNotifications();
        $this->set('notifications', $notifications);

        $this->set('title_for_layout', 'Notification - Index');
    }


    /**
     * Retrieves a notification
     *
     * @access public
     * @param string $notificationId
     * @return void
     */
    public function view($notificationId)
    {
        $notification = $this->Notification->fetchNotification($notificationId);
        $this->set('notification', $notification);
        $this->set('title_for_layout', 'Notification - View');
    }


    /**
     * Creates a new notification
     *
     * @access public
     * @return void
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
     * Retrieves a notification to edit of save changes to a notification
     *
     * @access public
     * @param $notificationId
     * @return void
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
     * Deletes a notification
     *
     * @access public
     * @param string $notificationId
     * @return void
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
     * @access public
     * @param  $notificationHandle unique identifier
     * @return void
     */
    public function test($notificationHandle='')
    {
        $userId = $this->Session->read('Auth.User.id');
        $person = $this->Person->getPersonWith($userId, 'nothing');

        $additionalObjects = array();

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