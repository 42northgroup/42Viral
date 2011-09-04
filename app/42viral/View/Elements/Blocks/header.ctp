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
?>

<div id="Header">

    <div id="HeaderLeft">
        The 42Viral Project
        <?php if($this->Session->check('Auth.User.id')): ?>
            <?php 
                $googleAppsDomain = Configure::read('Google.Apps.domain');
                if(isset($googleAppsDomain)):
                    echo ' | ';
                    echo $this->Html->link('Google Apps', 'https://www.google.com/a/' . Configure::read('Google.Apps.domain')); 
                endif;
            ?>
        <?php endif; ?>
    </div>

    <div id="HeaderContent"></div>

    <div id="HeaderRight">
        
        <?php if($this->Session->check('Auth.User.id')): ?>
            <?php echo $this->Html->link('My Account', $this->Session->read('Auth.User.private_url')); ?>
            <?php echo " | "; ?>
            <?php echo $this->Html->link('Logout', '/users/logout'); ?>
        <?php else: ?>
            <?php echo $this->Html->link('New Account', '/users/create'); ?>
            <?php echo " | "; ?>        
            <?php echo $this->Html->link('Login', '/users/login'); ?>
        <?php endif; ?>
    </div>

</div>