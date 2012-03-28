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
<h1><?php //echo $title_for_layout; ?></h1>

<div class="row">
    <div class="five columns alpha">    
        <a href="/oauth/linkedin_connect"  class="connect">
            <?php echo $this->Html->image('/img/graphics/social_media/production/linkedin32.png'); ?>
            Connect with LinkedIn
        </a>
    </div>
    <div class="five columns"> 
        <a href="/oauth/facebook_connect" class="connect">
            <?php echo $this->Html->image('/img/graphics/social_media/production/facebook32.png'); ?>
            Connect with Facebook
        </a>
    </div>        
    <div class="five columns"> 
        <a href="/oauth/twitter_connect" class="connect">
            <?php echo $this->Html->image('/img/graphics/social_media/production/twitter32.png'); ?>
            Connect with Twitter
        </a>
    </div>     
    <div class="one column omega"></div>     
</div>
<div class="row">
    <div class="five columns alpha"> 
        <a href="/oauth/google_connect" class="connect">
            <?php echo $this->Html->image('/img/graphics/social_media/production/GooglePlus32.png'); ?>
            Connect with Google+
        </a>
    </div> 
    <div class="five columns"></div> 
    <div class="five columns"></div>     
    <div class="one column omega"></div>      
</div>

