<?php

$headerMenu = array();

if($this->Session->check('Auth.User.id')):

    $username = $this->Session->read('Auth.User.username');
    $messageBadge = empty($unreadMessageCount)?'':" ({$unreadMessageCount})";

    $headerMenu = array(
        'Items'=>array(
            array(
                'text'=>__('Profiles'),
                'url'=>"/profiles/",
                'options'=>array(),
                'confirm'=>null
            ),
            array(
                'text'=>__('Inbox') . $messageBadge,
                'url'=>"/notifications/",
                'options'=>array(),
                'confirm'=>null
            ),
            array(
                'text'=>__('My Account'),
                'url'=>"/profiles/view/{$username}/",
                'options'=>array(),
                'confirm'=>null
            ),
            array(
                'text'=>__('Logout'),
                'url'=>"/users/logout/",
                'options'=>array(),
                'confirm'=>null,
            ),
        ),
    );

else:

    $headerMenu = array(
        'Items'=>array(
            array(
                'text'=>__('Profiles'),
                'url'=>'/profiles/',
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