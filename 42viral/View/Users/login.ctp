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
?>
<h1><?php echo $title_for_layout; ?></h1>

<div class="row">
    <div class="four columns alpha">

        <?php

        echo $this->Form->create('User', array(
            'url'=>$this->here,
            'class'=>'responsive'
        ));

        if(!isset($lockout)):
            echo $this->Form->input('username');
            echo $this->Form->input('password');
            echo $this->Form->submit('Login');
        
        else:
            echo '<span style="color:red; font-weight:bold" >'.
                    'Too many failed login attempts. Your account will be locked out for the next 30 minutes.'
                .'</span>';
        endif;
        
        echo $this->Form->end();
        ?>

        <div class="block top navigation-block">
                <a href="/users/pass_reset_req">Forgot your password?</a>
        </div>
    </div>

    <div class="one column">&nbsp;</div>
    
    <div class="five columns">
        <?php
        echo $this->SocialMedia->link(
            'LinkedIn',
            'Connect with LinkedIn',
            '/oauth/linkedin_connect',
            array(
                'class' => 'connect',
                'target' => '_blank',
                'escape' => false
            ));
        
        echo $this->SocialMedia->link(
            'Facebook',
            'Connect with Facebook',
            '/oauth/facebook_connect',
            array(
                'class' => 'connect',
                'target' => '_blank',
                'escape' => false
            ));
        
        echo $this->SocialMedia->link(
            'Twitter',
            'Connect with Twitter',
            '/oauth/twitter_connect',
            array(
                'class' => 'connect',
                'target' => '_blank',
                'escape' => false
            ));

        echo $this->SocialMedia->link(
            'GooglePlus',
            'Connect with Google+',
            '/oauth/google_connect',
            array(
                'class' => 'connect',
                'target' => '_blank',
                'escape' => false
            ));
        ?>
    </div>
    
    <div class="six columns alpha"></div>
</div>
