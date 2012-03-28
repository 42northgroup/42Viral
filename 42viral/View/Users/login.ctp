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
        <a href="/oauth/linkedin_connect"  class="connect">
            <?php echo $this->Html->image('/img/graphics/social_media/production/linkedin32.png'); ?>
            Connect with LinkedIn
        </a>

        <a href="/oauth/facebook_connect" class="connect">
            <?php echo $this->Html->image('/img/graphics/social_media/production/facebook32.png'); ?>
            Connect with Facebook
        </a>

        <a href="/oauth/twitter_connect" class="connect">
            <?php echo $this->Html->image('/img/graphics/social_media/production/twitter32.png'); ?>
            Connect with Twitter
        </a>

        <a href="/oauth/google_connect" class="connect">
            <?php echo $this->Html->image('/img/graphics/social_media/production/GooglePlus32.png'); ?>
            Connect with Google+
        </a>
    </div> 
    
    <div class="six columns alpha"></div>

</div>
