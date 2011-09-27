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
abstract class NotificationAbstractController extends AppController
{

    public $uses = array('Person', 'Notification');
    public $components = array('NotificationCmp');

/**
 * Default action for the notification controller
 *
 * @access public
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
    public function index()
    {
        
    }

/**
 * Action to test working of the notification component
 *
 * @return void
 * @access public
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
    public function test()
    {
        $userId = $this->Session->read('Auth.User.id');
        $person = $this->Person->fetchPersonWith($userId, array(), 'id');

        $additionalObjects = array(
            'Company' => array(
                'name' => 'ABC Company',
                'address' => '123 Main St Suite 321, NY 12345'
            )
        );

        $notification = $this->Notification->fetchNotification('test_notification');
        if(empty($notification)) {
            $this->Notification->generateDummyTestNotification();
        }

        $this->NotificationCmp->triggerNotification('test_notification', $person, $additionalObjects);

        $this->Session->setFlash('Notification was fired', 'success');
        $this->redirect('/notification/index');
    }

}
