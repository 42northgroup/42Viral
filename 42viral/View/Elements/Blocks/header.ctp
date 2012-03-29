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
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

<div id="Header">
    <div class="clearfix squeeze">
        <div id="LogoContainer">The 42Viral Project</div>
        
        <div id="MobileHeader" class="clearfix">
            
            <div class="logo-container">The 42Viral Project</div>
            
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
                    <div class="navigation"><a href="/blogs/">Blogs</a></div>
                    <div class="navigation"><a href="/members/">Members</a></div>
                    <div class="navigation"><a href="/pages/">Pages</a></div>
                    <div class="navigation">
                        <?php 
                            $messageBadge = empty($unread_message_count)?'':" ({$unread_message_count})";
                            echo $this->Html->link("Inbox{$messageBadge}", '#'); ?>
                        <div class="subnavigation">
                            <div><?php echo $this->Html->link("All Messages", '/inbox_message/'); ?></div>
                        </div>
                    </div>
                    <div class="navigation">
                        <a href="#">Share</a>
                        <div class="subnavigation">
                            <div><?php echo $this->Html->link('Socialize', '/users/social_media/'); ?></div>
                            <div><?php echo $this->Html->link('Create a blog', '/blogs/create/'); ?></div>
                            <div><?php echo $this->Html->link('Create a post', '/posts/create/'); ?></div>
                        </div>
                    </div>
                    <div class="navigation">
                        
                        <a href="#">My Account</a>
                        <div class="subnavigation">
                            <strong>Profile</strong>
                            <div>
                                <div>
                                <?php echo $this->Html->link('My Profile', 
                                    '/members/view/' . $this->Session->read('Auth.User.username')); ?>
                                </div>
                                <?php echo $this->Html->link('Edit', 
                                    '/profiles/edit/' . $this->Session->read('Auth.User.Profile.id')); ?>
                            </div>
                            
                            <strong>Misc</strong>
                            <div><?php echo $this->Html->link('Photos', 
                                    '/uploads/images/' . $this->Session->read('Auth.User.username')); ?></div> 

                            <div><?php echo $this->Html->link('Connect', '/oauth/connect/' ); ?></div>  

                            <div><?php echo $this->Html->link('Settings', '/users/settings/' ); ?></div> 

                            <div><?php echo $this->Html->link('Logout', '/users/logout'); ?></div>  
                        </div>
                    </div>
                    <?php if($this->Session->check('Auth.User.id')): ?>
                        <?php if($this->Session->read('Auth.User.employee') == 1): ?>
                            <div class="navigation">
                                <a href="#">Admin</a>
                                <div class="subnavigation">
                                    
                                    <strong>CMS</strong>
                                    <div>
                                        <?php echo $this->Html->link('Create a web page', '/admin/pages/create/'); ?>
                                    </div>
                                    <div>
                                        <?php echo $this->Html->link('Pages', '/admin/pages/'); ?>
                                    </div>
                                    
                                    <strong>CRM</strong>
                                    <div><?php echo $this->Html->link('People', '/admin/people/'); ?></div>
                                    
                                    <strong>Messaging</strong>
                                    <div><?php echo $this->Html->link('Notifications', '/notification/index/'); ?></div>
                                    <div><?php echo $this->Html->link(' - Create', '/notification/create/'); ?></div>
                                    <div><?php echo $this->Html->link('Invite a Friend', '/people/invite/'); ?></div>
                                    
                                    <strong>System</strong>
                                    <div><?php echo $this->Html->link('Users', '/admin/users/'); ?></div>
                                    <div><?php echo $this->Html->link('Groups', 
                                            '/admin/users/acl_groups/'); ?></div>
                                    <div><?php echo $this->Html->link('Picklists', 
                                            '/admin/picklist_manager/picklists/'); ?></div>
                                    <div><?php echo $this->Html->link('Plugins', 
                                            '/admin/plugin_configuration/configurations/'); ?></div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div id="Navigation">
                    <div class="navigation"><a href="/blogs/">Blogs</a></div>
                    <div class="navigation"><a href="/members/">Members</a></div>
                    <div class="navigation"><a href="/pages/">Pages</a></div>
                    <div class="navigation"><?php echo $this->Html->link('New Account', '/users/create'); ?></div>
                    <div class="navigation"><?php echo $this->Html->link('Login', '/users/login'); ?></div>
                </div>
            <?php endif; ?>
        </div>
        
    </div>
</div>