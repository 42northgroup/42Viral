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

<div id="Banner">

    <div class="banner-navigation">
        <?php echo $this->Html->link('Profiles', '/members/' ); ?>
        <?php echo $this->Html->link('Content', '/contents/content/' ); ?>

        <?php echo $this->Html->link('Photos', '/uploads/images/' ); ?>
        <?php echo $this->Html->link('Companies', '/companies/mine/' ); ?>
        <?php echo $this->Html->link('Connect', '/oauth/connect/' ); ?>
    </div>

    <div class="banner-sub-navigation">
    <?php

        switch($this->request->params['controller']){
            case 'contents';
                echo $this->Access->link('Contents-blog_create', 'Create a blog', '/contents/blog_create/');
                echo ' / ';
                echo $this->Access->link('Contents-post_create', 'Post to a blog', '/contents/post_create/');
                echo ' / ';
                echo $this->Access->link('Contents-page_create', 'Create a web page', '/contents/page_create/');     
                echo ' / ';
                echo $this->Access->link('Contents-page_create', 'Socialize', '/users/social_media/');  
            break;     
        }

    ?>
    </div>

</div>