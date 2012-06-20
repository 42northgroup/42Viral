<?php
/**
 * Manage notification template objects
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
 * @package 42viral\Notification
 */

App::uses('AppModel', 'Model');
App::uses('Handy', 'Lib');
App::uses('CakeEmail', 'Network/Email');
App::uses('Scrub', 'Lib/Scrub');
/**
 * Manage notification template objects
 * @author Jason D Snider <jason.snider@northgroup.com>
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
                'htmlStrict' => array('body'),
                'noHTML' => array('id', 'subject'),
            )
        )
    );

    private $__notificiations = array(
        'en'=>array(
/*
                'sample_notification_template' => array(

                    '_ref'=>'sample_notification_template',

                    'notification'=>array(
                            'active'=>true,
                            'subject'=>'Sample',
                            'body'=>
'<p>Sample Notification text content, may contain sprintf variables %s, %d, etc</p>'
                    ),

                    'email'=>array(
                            'active'=>true,
                            'subject'=>'Password Reset',

                            'html_body'=>
'<p>HTML content, may contain sprintf variables %s, %d, etc</p>',

                            'text_body'=>
//For the sake of formatting we need to start at the left most margin and violae the 120 margin rule
'Plain text content, may contain sprintf variables %s, %d, etc'
                    )
                )
            ),
*/
            'password_reset' => array(

                '_ref'=>'password_reset',

                'notification'=>array(
                    'active'=>true,
                    'subject'=>'Password Reset',
                    'body'=>

'<p>Just letting you know, a password reset has been requested against your account.</p>
<p>The IP address of the person requesting this password reset is: %s</p>'
                ),

                'email'=>array(
                    'active'=>true,
                    'subject'=>'Password Reset',

                    'html_body'=>

'<p>Please do not reply to this email. This email has been sent by a machine, replies will not be read.</p>

Hello,<br>

<p>Someone (hopefully you) has requested to reset your password for %2$s. If you did not request this reset, please ignore this message.</p>

<p>To reset your password, please visit the following page:</p>
<p>%1$spass_reset/%3$s</p>

<p>If asked, your password reset key is : %3$s</p>

<p>When you visit the above page (which you must do within 24 hours), you will be prompted to enter a new password. After you have submitted the form, you can log in normally using the new password you set.</p>

<p>The IP address of the person requesting this password reset is: %4$s</p>',



                    'text_body'=>

'Please do not reply to this email. This email has been sent by a machine, replies will not be read.

Hello,

Someone (hopefully you) has requested to reset your password for %2$s. If you did not request this reset, please ignore this message.

To reset your password, please visit the following page:
%1$spass_reset/%3$s

If asked, your password reset key is : %3$s

When you visit the above page (which you must do within 24 hours), you will be prompted to enter a new password. After you have submitted the form, you can log in normally using the new password you set.

The IP address of the person requesting this password reset is: %3$s'
                )
            ),
            'invitation_to_join' => array(

                    '_ref'=>'invitation_to_join',

                    'notification'=>array(
                            'active'=>false,
                            'subject'=>null,
                            'body'=>null
                    ),

                    'email'=>array(
                            'active'=>true,
                            'subject'=>'Invitation to Join',

                            'html_body'=>

'<p>%1$s has invited you to join %2$s</p>
<p>Click the link below to join 42Viral:</p>
<p>/%3$susers/create/invite:/%4$s</p>
<p>If asked, your invitation code is : %4$s</p>',

                            'text_body'=>
'%1$s has invited you to join %2$s

Click the link below to join 42Viral:

/%3$susers/create/invite:/%4$s

If asked, your invitation code is : %4$s',
                    )
            )
        )

    );

    /**
     * Sends notifications and emails, seemlessly, in the background
     * options array
     *     'email' - email settings
     *     'message' - message variables
     *     'type' - email, notification or all (all by default)
     * @param string $notification
     * @param array $options
     *
     * @todo Complete configuration modeling
     */
    public function notify($notification, $options = array()){
        $language = 'en';
        $message = $this->__notificiations[$language][$notification];

        $sendEmail = false;
        $sendNotification = false;

        switch($options['type']){
            case 'email':
                $sendEmail = true;
                $sendNotification = false;
                break;

            case 'notification':
                $sendEmail = false;
                $sendNotification = false;
                break;

            case 'all':
            default:
                $sendEmail = true;
                $sendNotification = true;
                break;
        }

        if($sendNotification && $message['notification']['active']){

            $data['Notification']['person_id'] = $options['additional']['person_id'];
            $data['Notification']['subject'] = $message['email']['subject'];
            $data['Notification']['body'] = $this->__prepareNotification($notification, $options['message']);

            if($this->save($data)){

            }
        }

        if($sendEmail && $message['email']['active']){
            $email = new CakeEmail();
            $email->template('notification', null)
                ->transport('Mail')
                ->emailFormat('both')

                ->to($options['email']['to'])
                ->from(array(Configure::read('Email.from') => Configure::read('Domain.host')))
                ->replyTo(Configure::read('Email.replyTo'))

                ->subject($message['email']['subject'])
                ->viewVars($this->__prepareEmail($notification, $options['message']))
                ->send();
        }

    }

    /**
     * Prepares the final text of a notification
     * @access private
     * @param string $notification
     * @param array $options
     */
    private function __prepareNotification($notification, $options = null){
        $body = '';
        $language = 'en';
        $message = $this->__notificiations[$language][$notification];

        switch($notification){
            case 'invitation_to_join':
                return false;
                break;

            case 'password_reset':
                    $body = sprintf($message['notification']['body'], $options['ip']);
                break;
        }

        return $body;

    }

    /**
     * Prepares the final text of an email
     * @access private
     * @param string $notification
     * @param array $options
     */
    private function __prepareEmail($notification, $options = null){
        $html = '';
        $text = '';
        $language = 'en';
        $message = $this->__notificiations[$language][$notification];

        switch($notification){
            case 'invitation_to_join':
                $html = sprintf(
                $message['email']['html_body'],
                $options['invitee'],
                Configure::read('Domain.host'), //Product or Domain
                Configure::read('Domain.url'), //FQDN
                $options['token']
                );
                break;

            case 'password_reset':
                $html = sprintf(
                    $message['email']['html_body'],
                    Configure::read('Domain.url'), //FQDN
                    Configure::read('Domain.host'), //Product or Domain
                    $options['token'],
                    $options['ip']
                );

                $text = sprintf(
                    $message['email']['text_body'],
                    Configure::read('Domain.url'),  //FQDN
                    Configure::read('Domain.host'), //Product or Domain
                    $options['token'],
                    $options['ip']
                );
                break;
        }

        return array('html'=>Scrub::htmlStrict($html), 'text'=>Scrub::noHTML($text));

    }
}










