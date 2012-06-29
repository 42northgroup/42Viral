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

$profileId = $this->Session->read('Auth.User.Profile.id');
$username = $this->Session->read('Auth.User.username');
$userId = $this->Session->read('Auth.User.id');
?>

<div id="Header">
    <div class="clearfix squeeze">
        <div id="LogoContainer">
            <a href="/">The 42Viral Project</a>
        </div>

        <div id="MobileHeader" class="clearfix">

            <div class="logo-container">
                <a href="/">The 42Viral Project</a>
            </div>

            <a id="MobileNavigationTrigger" class="btn btn-navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

        </div>

        <div id="NavigationContainer">
            <div id="NavigationHeader">
                <a id="NavigationTrigger" class="btn btn-navbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
            </div>

            <?php if($this->Session->check('Auth.User.id')): ?>
                <div id="Navigation">
                    <div class="navigation"><?php echo $this->Html->link(__('Search'), '/searches/'); ?></div>
                    <div class="navigation"><?php echo $this->Html->link(__('Blogs'), '/blogs/'); ?></div>
                    <div class="navigation"><?php echo $this->Html->link(__('Profiles'), '/profiles/'); ?></div>
                    <div class="navigation"><?php echo $this->Html->link(__('Pages'), '/pages/'); ?></div>
                    <div class="navigation">
                        <?php
                        $messageBadge = empty($unreadMessageCount)?'':" ({$unreadMessageCount})";
                        echo $this->Html->link(__('Inbox') . $messageBadge, '/notifications/'); ?>
                    </div>
                    <div class="navigation">
                        <a href="#">Share</a>
                        <div class="subnavigation">
                            <div><?php echo $this->Html->link(__('Socialize'), '/users/social_media/'); ?></div>
                            <div><?php echo $this->Html->link(__('Create a blog'), '/blogs/create/'); ?></div>
                            <div><?php echo $this->Html->link(__('Create a post'), '/posts/create/'); ?></div>
                        </div>
                    </div>
                    <div class="navigation">

                        <a href="<?php echo "/profiles/view/{$username}/"; ?>">My Account</a>
                        <div class="subnavigation">
                            <div><?php echo $this->Html->link(__('Invite a friend'), '/people/invite/'); ?></div>
                            <div><?php echo $this->Html->link(__('Logout'), '/users/logout/'); ?></div>
                        </div>
                    </div>

                </div>
            <?php else: ?>
                <div id="Navigation">
                    <div class="navigation"><?php echo $this->Html->link(__('Search'), '/searches/'); ?></div>
                    <div class="navigation"><?php echo $this->Html->link(__('Blogs'), '/blogs/'); ?></div>
                    <div class="navigation"><?php echo $this->Html->link(__('Profiles'), '/profiles/'); ?></div>
                    <div class="navigation"><?php echo $this->Html->link(__('Pages'), '/pages/'); ?></div>
                    <div class="navigation"><?php echo $this->Html->link(__('New Account'), '/users/create/'); ?></div>
                    <div class="navigation"><?php echo $this->Html->link(__('Login'), '/users/login/'); ?></div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>