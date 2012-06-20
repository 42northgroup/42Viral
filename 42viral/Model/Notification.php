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
App::uses('CakeEmail', 'Network/Email');
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
                'htmlStrict' => array('body'),
                'noHTML' => array('id', 'subject'),
            )
        )
    );

    private $__notificiations = array(
        'en'=>array(
            'password_reset' => array(

                '_ref'=>'password_reset',

                'notification'=>array(
                    'active'=>true,
                    'subject'=>'Password Reset',
                    'body'=>'<p>Just letting you know, a password reset has been requested against your account.</p>'
                ),

                'email'=>array(
                    'active'=>true,
                    'subject'=>'Password Reset'
                )
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
     * options array
     *     'email' - email settings
     *     'message' - message variables
     * @param string $notification
     * @param array $options
     */
    public function notify($notification, $options){
        $language = 'en';
        $message = $this->__notificiations[$language][$notification];

        if($message['notification']['active']){

            $data['Notification']['body'] = $message['notification']['body'];

            if($this->save($data)){
                //debug('Data Saved!');
            }
            //debug('Here I will save the notificaiton to the users notification inbox!');
        }

        if($message['email']['active']){
            //debug('Here I will return an email array to be passed into the email component');
        }

    }
}