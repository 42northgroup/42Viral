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
<div id="Header" class="clearfix">

    <div id="HeaderLeft">
        The 42Viral Project
        <?php if($this->Session->check('Auth.User.id')): ?>
            <?php 
                $googleAppsDomain = Configure::read('Google.Apps.domain');
                if(isset($googleAppsDomain)):
                    echo $this->Html->link('Google Apps', 'https://www.google.com/a/' 
                            . Configure::read('Google.Apps.domain')); 
                endif;
            ?>
        <?php endif; ?>
    </div>

    <div id="HeaderContent"></div>

    <div id="HeaderRight">      

        <?php if($this->Session->check('Auth.User.id')): ?>
            <div style="position:relative; float:left; padding:0 6px;">
                <?php 
                    if($unread_message_count > 0) {
                        
                        $inbox = $this->Html->link(
                            'Inbox (' . $unread_message_count . ')',
                            '/inbox_message/',
                            array(
                                'style' => 'font-weight: bold;',
                                'id'=>'Inbox', 
                                'class'=>'navigation-link'
                            )
                        );
                        
                    } else {
                        
                        $inbox = $this->Html->link(
                            'Inbox',
                            '/inbox_message/',
                            array(
                                'id'=>'Inbox', 
                                'class'=>'navigation-link'
                            )
                        );
                        
                    }                    
                    
                    echo $inbox;
                ?>
                
                <div class="navigation-block" id="InboxBlock">     
                    <?php

                        echo $this->Html->link(
                            'All Messages',
                            '/inbox_message/all_messages/'
                        );
                        echo $this->Html->link('[Populate Inbox - temp]', '/inbox_message/populate_inbox/' );
                    ?>
                </div>
                
            </div>    
        
            <div style="position:relative; float:left; padding:0 6px;">
                <?php echo $this->Html->link('Share', '#', array('id'=>'Share', 'class'=>'navigation-link')); ?>
                <div class="navigation-block" id="ShareBlock">
                    <?php
                        echo $this->Access->link('Contents-page_create', 'Socialize', '/users/social_media/');  
                        echo $this->Access->link('Contents-blog_create', 'Create a blog', '/contents/blog_create/');
                        echo $this->Access->link('Contents-post_create', 'Create a post', '/contents/post_create/');   
                        echo $this->Access->link('Companies-create', 'Create a company', '/companies/create');  
                    ?>
                </div>
            </div>   
        
            <div style="position:relative; float:left; padding:0 6px;">
 
                <?php 
                    echo $this->Html->link('My Account', $this->Session->read('Auth.User.url'), 
                            array('id'=>'MyAccount', 'class'=>'navigation-link')); 
                ?>
                <div class="navigation-block" id="MyAccountBlock">
                    <?php 
                    
                        echo $this->Html->link('Profile', '/members/view/' 
                                . $this->Session->read('Auth.User.username'));
                        
                        echo $this->Html->link('Content', '/contents/content/' 
                                . $this->Session->read('Auth.User.username'));
                        
                        echo $this->Html->link('Photos', '/uploads/images/' 
                                . $this->Session->read('Auth.User.username'));
                        
                        echo $this->Html->link('Companies', '/companies/index/' 
                                . $this->Session->read('Auth.User.username'));
                        
                        echo $this->Html->link('Connect', '/oauth/connect/' );
                        echo $this->Html->link('Settings', '/users/settings/' );
                        echo $this->Html->link('Logout', '/users/logout');
                    ?>
                </div>             
            </div>

        <?php else: ?>
        
            <div style="position:relative; float:left; padding:0 6px;">
                <?php echo $this->Html->link('New Account', '/users/create'); ?>  
            </div>
        
            <div style="position:relative; float:left; padding:0 6px;">     
                <?php echo $this->Html->link('Login', '/users/login'); ?>
            </div>
        
        <?php endif; ?>
            
    </div>

</div>