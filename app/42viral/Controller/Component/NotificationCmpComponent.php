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

App::uses('Notification', 'Model');
App::uses('InboxMessage', 'Model');
App::uses('Person', 'Model');

App::uses('MicroTemplate', 'Lib');

/**
 * @package app
 * @subpackage app.core
 *** @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
class NotificationCmpComponent extends Component
{

/**
 * @access private
 * @var type
 */
    private $__classesPrepared = false;


    public $components = array('Email');

    
/**
 * @access private
 * @var type
 */
    private $__notificationCache = array();

/**
 * @access private
 * @var type
 */
    private $__fromEmail = '';

/**
 * @access private
 * @var string
 */
    private $__replyToEmail = '';

/**
 * @access private
 * @var string
 */
    private $__emailTemplate = '';

    
/**
 *
 *
 *** @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @access private
 */
    private function __customInit()
    {
        $this->__fromEmail = Configure::read('Email.from');
        $this->__replyToEmail = Configure::read('Email.replyTo');
        
        $this->__prepareClasses();
    }

/**
 * Make sure all required classes are present when being called from anywhere (cake shell, controller, etc.)
 *
 *** @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @access private
 */
    private function __prepareClasses()
    {
        //If classes were prepared once in the same process, don't bother
        if($this->__classesPrepared) {
            return;
        }

        $classList = array(
            'Notification',
            'Person',
            'InboxMessage'
        );

        foreach($classList as $oneClass) {
            if(!isset($this->{$oneClass})) {
                $this->{$oneClass}= ClassRegistry::init($oneClass);
            }
        }

        $this->__classesPrepared = true;
    }


/**
 * Generate and send an email using the information encapsulated within the $preparedNotification object
 *
 *** @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @access private
 * @param array $preparedNotification A prepared notification object which contains all information for
 * generating an actual email notification
 */
    private function __sendEmail($preparedNotification)
    {

        $this->Email->to = $preparedNotification['recipient_email'];

        $this->Email->subject = $preparedNotification['subject'];
        $this->Email->sendAs = 'html';

        $this->Email->from = $this->__fromEmail;
        $this->Email->replyTo = $this->__replyToEmail;
        $this->Email->template = 'notification';
        
        $this->Email->send($preparedNotification['body']);
        
    }

/**
 * API method to fire a notification for a given person using any additional objects to be substituted in the
 * notification template. Firing a notification includes firing an email and generating an inbox message of the same.
 *
 *** @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @access public
 * @param string $notificationHandle
 * @param Person $person
 * @param array $additionalObjects
 */
    public function triggerNotification($notificationHandle, $person, $additionalObjects=array())
    {
        
        $this->__customInit();
        
        $additionalObjects = array_merge($person, $additionalObjects);

        //Look for the notification in the cache first before querying the database
        if(array_key_exists($notificationHandle, $this->__notificationCache)) {
            $notification = $this->__notificationCache[$notificationHandle];
        } else {
            $notification = $this->Notification->fetchNotification($notificationHandle);
            $this->__notificationCache[$notificationHandle] = $notification;
        }

        $this->__emailTemplate = $notification['Notification']['email_template'];
        
        $preparedNotification = array();
        
        $subjectText = $notification['Notification']['subject_template'];
        $subjectText = MicroTemplate::applyTemplate($subjectText, $additionalObjects);
        $preparedNotification['subject'] = $subjectText;

        $bodyText = $notification['Notification']['body_template'];
        $bodyText = MicroTemplate::applyTemplate($bodyText, $additionalObjects);
        $preparedNotification['body'] = $bodyText;
            
        $preparedNotification['recipient_email'] = $person['Person']['email'];

        $this->__sendEmail($preparedNotification);
        $this->InboxMessage->addPersonInboxMessage($person['Person']['id'], $preparedNotification);
    }
    
    /**
 * API method to fire a notification to a number of email using any additional objects to be substituted in the 
 * notification template. Firing a notification includes firing an email and generating an inbox message of the same.
 *
 *** @author Lyubomir R Dimov <lrdimov@yahoo.com>
 * @access public
 * @param string $notificationHandle 
 * @param array $additionalObjects
 */
    public function triggerSimpleNotification($notificationHandle, $emails = array(), $additionalObjects=array())
    {
        
        $this->__customInit();

        //Look for the notification in the cache first before querying the database
        if(array_key_exists($notificationHandle, $this->__notificationCache)) {
            $notification = $this->__notificationCache[$notificationHandle];
        } else {
            $notification = $this->Notification->fetchNotification($notificationHandle);
            $this->__notificationCache[$notificationHandle] = $notification;
        }

        $this->__emailTemplate = $notification['Notification']['email_template'];
        
        $preparedNotification = array();
 
        $subjectText = $notification['Notification']['subject_template'];
        $subjectText = MicroTemplate::applyTemplate($subjectText, $additionalObjects);
        $preparedNotification['subject'] = $subjectText;
        
        $bodyText = $notification['Notification']['body_template'];
        $bodyText = MicroTemplate::applyTemplate($bodyText, $additionalObjects);
        $preparedNotification['body'] = $bodyText;
                     
        $preparedNotification['recipient_email'] = '';
        
        foreach ($emails as $email){
            $preparedNotification['recipient_email'] .= $email.',';            
        }
        
        $preparedNotification['recipient_email'] = substr($preparedNotification['recipient_email'], 0, -1);
        
        $this->__sendEmail($preparedNotification);        
    }
}