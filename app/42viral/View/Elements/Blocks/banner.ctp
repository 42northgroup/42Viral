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

<?php if($this->Session->check('Auth.User.id')): ?>
    <div id="Banner">

        <div class="banner-navigation">
            <strong>My Stuff:</strong>
            <?php 
                echo $this->Html->link('Profile', '/members/view/' . $this->Session->read('Auth.User.username'));
                echo ' / ';
                echo $this->Html->link('Content', '/contents/content/' . $this->Session->read('Auth.User.username'));
                echo ' / ';
                echo $this->Html->link('Photos', '/uploads/images/' . $this->Session->read('Auth.User.username'));
                echo ' / ';
                echo $this->Html->link('Companies', '/companies/index/' . $this->Session->read('Auth.User.username'));
                echo ' / ';
                echo $this->Html->link('Connect', '/oauth/connect/' );
            ?>
        </div>

        <div class="banner-sub-navigation">
            <strong>Create and Share:</strong>
            <?php
                echo $this->Access->link('Contents-page_create', 'Socialize', '/users/social_media/');  
                echo ' / ';
                echo $this->Access->link('Contents-blog_create', 'Create a blog', '/contents/blog_create/');
                echo ' / ';
                echo $this->Access->link('Contents-post_create', 'Create a post', '/contents/post_create/');   
                echo ' / ';
                echo $this->Access->link('Companies-create', 'Create a company', '/companies/create');  
            ?>
        </div>

    </div>
<?php endif; ?>