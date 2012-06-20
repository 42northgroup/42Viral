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
 * @package       42viral\app
 */

App::uses('AppController', 'Controller');

/**
 * @author Jason D Snider <jason.snider@northgroup.com>
 */
 class NotificationsController extends AppController
{

     /**
     * Models this controller uses
     * @var array
     * @access public
     */
    public $uses = array('Notification');

    /**
     * Default action for the notification controller
     * @access public
     */
    public function index($location = 'inbox', $marked = null)
    {

        if(is_null($marked)){
            $conditions = array(
                'Notification.person_id'=>$this->Session->read('Auth.User.id'),
                'Notification.location'=>$location
            );
        }else{
            $conditions = array(
                'Notification.person_id'=>$this->Session->read('Auth.User.id'),
                'Notification.location'=>$location,
                'Notification.marked'=>$marked,
            );
        }

        $notifications = $this->Notification->find(
            'all',
            array(
                'conditions'=>$conditions,
                'contain'=>array(),
                'fields'=>array(
                    'Notification.id',
                    'Notification.subject',
                    'Notification.body'
                )
            )
        );

        $this->set('notifications', $notifications);
        $this->set('title_for_layout', 'Notification - ' . Inflector::humanize($location));
    }

    /**
     * Retrieves a notification
     * @access public
     * @param string $notificationId
     */
    public function view($notificationId)
    {
        $notification = $this->Notification->find(
            'first',
            array(
                'conditions'=>array(
                    'Notification.id' => $notificationId
                ),
                'contain'=>array(),
                'fields'=>array(
                    'Notification.id',
                    'Notification.subject',
                    'Notification.body',
                    'Notification.marked',
                )
            )
        );

        //If the notification isn't marked as read, mark it as such.
        if($notification['Notification']['marked'] != 'read'){
            $data['Notification']['id'] = $notificationId;
            $data['Notification']['marked'] = 'read';
            $this->Notification->save($data);
        }

        $this->set('notification', $notification);
        $this->set('title_for_layout', $notification['Notification']['subject']);
    }

    /**
     * Deletes a notification
     *
     * @access public
     * @param string $notificationId
     *
     */
    public function delete($notificationId)
    {
        //placeholder
    }

}