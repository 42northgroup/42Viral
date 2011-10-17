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

echo $this->element('Navigation' . DS . 'local', array('section'=>'')); 

echo $this->Form->create(
    'Person',
    array(
        'url' => "/users/pass_reset/{$reset_token}",
        'class'=>'default'
    )
);

echo $this->Form->input('id', array(
    'type' => 'hidden',
    'value' => $user_id
));

echo $this->Form->input('password', array(
    'style' => 'margin-bottom: 5px;'
));

echo $this->Form->input('verify_password', array(
    'label' => 'Verify Password',
    'type' => 'password',

    'style' => 'margin-bottom: 5px;'
));

echo $this->Form->submit();

echo $this->Form->end();