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
#LogoContainer{
    float: left;
    color: #fff;
}

#NavigationContainer{
    float:right;
}

#NavigationContainer a:link,
#NavigationContainer a:visited{
    color: #fff;
}

#Navigation{}

#NavigationHeader{
    display: none;
} 

.navigation{
    display:inline;
    position: relative;
}

.subnavigation{
    float: left;
    position: absolute;
    background: #000;
    display: none;
}

/* Twitter Bootstrap */
.btn-navbar .icon-bar + .icon-bar {
    margin: 3px 4px 0 0;
}
.btn-navbar .icon-bar {
    display: block;
    width: 18px;
    height: 2px;
    background-color: whiteSmoke;
    -webkit-border-radius: 1px;
    -moz-border-radius: 1px;
    border-radius: 1px;
    -webkit-box-shadow: 0 1px 0 rgba(0, 0, 0, 0.25);
    -moz-box-shadow: 0 1px 0 rgba(0, 0, 0, 0.25);
    box-shadow: 0 1px 0 rgba(0, 0, 0, 0.25);
}

@media screen and (max-width: 1024px){}

@media screen and (max-width: 768px){
    #NavigationHeader{
        display: block;
    } 
    
    #Navigation{
        background: #000;
        display: none;
        float:left;
        position: absolute;
        border-bottom-left-radius: 6px;
        right: 0;   
    }
    
    .navigation{
        display:block;
        position: relative;
        border-bottom: 1px solid #aaa;
    }
    
    .navigation a:link,
    .navigation a:visited{
        color: #fff;
        font-size: 1.8em; 
        padding: .5em .8em; 
    }
    
    .subnavigation{
        float: none;
        position: relative;
        margin: 0 0 0 8px;
    }
    
    .subnavigation a:link,
    .subnavigation a:visited{
        color: #fff;
        font-size: 1.0em; 
        padding: .3em 1.0em; 
    }    
}

@media screen and (max-width: 480px) {
    #LogoContainer{
        display:none;
    }
    
    #NavigationContainer{
        float: none;
        display:block;
    }
    
    #NavigationHeader{
        display: none;
    } 
    
    #MobileHeader{
        display: block;
        color: #fff;
    } 
    
    #Navigation{
        background: #000;
        display: block;
        float:none;
        position: relative;
        border-radius: 0; 
    }
    
    .navigation{
        display:block;
        position: relative;
        border-bottom: 1px solid #aaa;
    }
    
    .navigation a:link,
    .navigation a:visited{
        color: #fff;
        font-size: 1.8em; 
        padding: .5em .8em; 
    }
    
    .subnavigation{
        float: none;
        position: relative;
        margin: 0 0 0 8px;
    }
    
    .subnavigation a:link,
    .subnavigation a:visited{
        color: #fff;
        font-size: 1.0em; 
        padding: .3em 1.0em; 
    } 
}
</style>

<script type="text/javascript">
    $(function(){
        $("#NavigationTrigger, #MobileNavigationTrigger").click(function(){
            $("#Navigation").toggle();
        });
        
        /* Controls table navigation in regaurds to double row stacking */
        /*
        $(function(){
            $('#Navigation').delegate('.navigation','click',function(){
                $(this).find('div.subnavigation:first').toggle();
            });
        });   */    
    });
</script>

<div id="Header">
    <div class="clearfix">
        <div id="LogoContainer">The 42Viral Project</div>
        <div id="NavigationMobileHeader">
            The 42Viral Project
            <a id="MobileNavigationTrigger" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
        </div>
        <div id="NavigationContainer">
            <div id="NavigationHeader">
                <a id="NavigationTrigger" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
            </div>
            <div id="Navigation">
                <div class="navigation">
                    <a href="#">Inbox</a>
                    <div class="subnavigation">
                        <div><a href="#">Test 4</a></div>
                        <div><a href="#">Test 5</a></div>
                    </div>
                </div>
                <div class="navigation"><a href="#">Share</a></div>
                <div class="navigation"><a href="#">My Account</a></div>
            </div>
            
        </div>
        
    </div>
</div>

<?php /*
<div id="Header">
    <div class="clearfix squeeze">
        <div id="HeaderLeft">
            The 42Viral Project
            <?php if($this->Session->check('Auth.User.id')): ?>
                <?php 
                    $googleAppsDomain = Configure::read('Google.Apps.domain');
                    if(!empty($googleAppsDomain)):
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
                                $this->Html->image('graphics/icons/solid-white/16/envolope.png').
                                '(' . $unread_message_count . ')',
                                '/inbox_message/',
                                array(
                                    'style' => 'font-weight: bold;',
                                    'id'=>'Inbox', 
                                    'class'=>'navigation-link',
                                    'escape'=>false
                                )
                            );

                        } else {

                            $inbox = $this->Html->image(
                                'graphics/icons/solid-white/16/envolope.png',
                                array(
                                    'id'=>'Inbox', 
                                    'class'=>'navigation-link',
                                    'url'=>'/inbox_message/'
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
                    
                    <?php 
                        echo $this->Html->image(
                            'graphics/icons/solid-white/16/share-social-network.png',
                            array(
                                'id'=>'Share', 
                                'class'=>'navigation-link',
                                'url'=>'#'
                            )
                        );         
                    ?>                    
                    <div class="navigation-block" id="ShareBlock">
                        <?php
                            echo $this->Html->link('Socialize', '/users/social_media/');  
                            echo $this->Html->link('Create a blog', '/blogs/create/');
                            echo $this->Html->link('Create a post', '/posts/create/');   
                        ?>
                    </div>
                </div>   

                <div style="position:relative; float:left; padding:0 6px;">
                    <?php 
                        echo $this->Html->image(
                            'graphics/icons/solid-white/16/gear.png',
                            array(
                                'id'=>'MyAccount', 
                                'class'=>'navigation-link',
                                'url'=>$this->Session->read('Auth.User.url')
                            )
                        );         
                    ?>
                    <div class="navigation-block" id="MyAccountBlock">
                        <?php 

                            echo $this->Html->link('Profile', '/members/view/' 
                                    . $this->Session->read('Auth.User.username'));

                            echo $this->Html->link('Content', '/contents/content/' 
                                    . $this->Session->read('Auth.User.username'));

                            echo $this->Html->link('Photos', '/uploads/images/' 
                                    . $this->Session->read('Auth.User.username'));

                            echo $this->Html->link('Connect', '/oauth/connect/' );
                            echo $this->Html->link('Settings', '/users/settings/' );
                            echo $this->Html->link('Logout', '/users/logout');
                        ?>
                    </div>             
                </div>

            <?php else: ?>

                <div style="position:relative; float:left; padding:0 6px;">
                    <?php 
                        echo $this->Html->image(
                            'graphics/icons/solid-white/16/create-profile.png',
                            array(
                                'id'=>'New Account', 
                                'class'=>'navigation-link',
                                'url'=>'/users/create',
                                'title'=>'Create an Account'
                            )
                        );       
                    ?>  
                </div>

                <div style="position:relative; float:left; padding:0 6px;">
                    <?php 
                        echo $this->Html->image(
                            'graphics/icons/solid-white/16/login.png',
                            array(
                                'id'=>'Login', 
                                'class'=>'navigation-link',
                                'url'=>'/users/login',
                                'title'=>'Login'
                            )
                        );       
                    ?>                      
                </div>

            <?php endif; ?>

        </div>
    </div>
</div> */
?>