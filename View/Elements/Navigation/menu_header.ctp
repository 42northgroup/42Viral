<?php
App::uses('ProfileUtility', 'Lib');

$headerMenu = array();

//Place these links in the header if we have an active user session
if($this->Session->check('Auth.User.id')):

    $username = $this->Session->read('Auth.User.username');
    $messageBadge = empty($unreadMessageCount)?'':" ({$unreadMessageCount})";

    $headerMenu = array(
        'Items'=>array(
            array(
                'text'=>__('Inbox') . $messageBadge,
                'url'=>"/notifications/",
                'options'=>array(),
                'confirm'=>null
            ),
            array(
                'text'=>__('Logout'),
                'url'=>"/users/logout/",
                'options'=>array(),
                'confirm'=>null,
            ),
            array(
                'text'=>ProfileUtility::avatar($this->Session->read('Auth.User'), 32),
                'url'=>"/people/view/{$username}/",
                'options'=>array(
                    'escape'=>false
                ),
                'confirm'=>null
            ),
        ),
    );

else:
//Place these links in the header if we DO NOT have an active user session
    $headerMenu = array(
        'Items'=>array(
            array(
                'text'=>__('People'),
                'url'=>'/people/',
                'options'=>array(),
                'confirm'=>null
            ),
            array(
                'text'=>__('New Account'),
                'url'=>'/users/create/',
                'options'=>array(),
                'confirm'=>null
            ),
            array(
                'text'=>__('Login'),
                'url'=>'/users/login/',
                'options'=>array(),
                'confirm'=>null,
            ),

        ),
    );

endif;

echo serialize(array('headerMenu' => $headerMenu));