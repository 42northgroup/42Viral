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

<style type="text/css">
    .social-connect{
        margin:0 20px 12px;
        float:left;
        color: #999;
        background: #ddd;
        padding: 6px;
        border-radius: 4px;
    }   
    
    .social-connect .blurb{
        margin:0 0 3px;
        vertical-align: top;
    } 
    
    .social-connect .connect{
        text-align: center;
    }       
    
</style> 
<h1>Get Connected</h1>
<div class="clearfix">
    
    <?php if($this->Access->serviceConfiguration('LinkedIn')): ?>
        <div class="social-connect">
            
            <div class="blurb">
                <?php echo $this->Html->image('/img/social_media_icons/social_networking_iconpack/linkedin_32.png'); ?>
                Connect with LinkedIn.
            </div>
            
            <div class="connect">
                <?php echo $this->Html->link('', '/oauth/linkedin_connect', array('class'=>'oauth-button linkedin')); ?>
            </div>
            
        </div>
    <?php endif; ?>
    
    <?php if($this->Access->serviceConfiguration('Facebook')): ?>
        <div class="social-connect">
            <div class="blurb">
                <?php echo $this->Html->image('/img/social_media_icons/social_networking_iconpack/facebook_32.png'); ?>
                Connect with Facebook.
            </div>
            <div class="connect">
                <?php echo $this->Html->link('', '/oauth/facebook_connect', array('class'=>'oauth-button facebook')); ?>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if($this->Access->serviceConfiguration('Twitter')): ?>
        <div class="social-connect">
            <div class="blurb">
                <?php echo $this->Html->image('/img/social_media_icons/social_networking_iconpack/twitter_32.png'); ?>
                Connect with Twitter.
            </div>
            <div class="connect">
                <?php echo $this->Html->link('', '/oauth/twitter_connect', array('class'=>'oauth-button twitter')); ?>
            </div>
        </div>
    <?php endif; ?>
</div>
