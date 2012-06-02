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
<style type="text/css">
    .facebook-post-wrapper{
        background-color: #3B5998;
        padding: 5px;
        border-radius: 5px;
        border: 1px solid black;
    }
    
    .facebook-post{
        padding: 5px 5px 15px 5px;
    }
    
    .googleplus-post{
        padding: 5px 5px 15px 5px;
    }
    
    .twitter-post{
        padding: 5px 5px 15px 5px;
    }
    
    .linkedin-post{
        padding: 5px 5px 15px 5px;
    }
    
    .google_plus-triangle{
        border-top-width: 0px;
        border-left-width: 0px;
        border-right-width: 20px;
        border-bottom-width: 20px;
        border-right-color: black;
        border-bottom-color: transparent;        
        border-style: solid;
        float: left;
        margin-right: -1px;
        margin-top: 31px;
    }
    
    .facebook-triangle{
        border-top-width: 0px;
        border-left-width: 0px;
        border-right-width: 20px;
        border-bottom-width: 20px;
        border-right-color: #3B5998;
        border-bottom-color: transparent;        
        border-style: solid;
        float: left;
        margin-right: -1px;
        margin-top: 31px;
    }
    
    .twitter-triangle{
        border-top-width: 0px;
        border-left-width: 0px;
        border-right-width: 20px;
        border-bottom-width: 20px;
        border-right-color: #4099FF;
        border-bottom-color: transparent;        
        border-style: solid;
        float: left;
        margin-right: -1px;
        margin-top: 31px;
    }
</style>

<div class="h1shim"></div>
<div class="row">
    
    <div class="two-thirds column alpha">
        <div style="margin:0 0 12px;">
            <?php foreach($user['Profile']['SocialNetwork'] as $socialNetwork): ?>
                <?php echo $this->SocialMedia->landingPage($socialNetwork); ?>
            <?php endforeach; ?>
        </div>
        <div id="ResultsPage">
            <h2><?php echo $this->Profile->name($userProfile['Person']); ?>'s Content</h2>
            
            <?php foreach($contents as $content):?>            
                <div class="clearfix status" style="width: 100%;">
                    <div style="float:left; width: 56px;">
                        <?php echo Inflector::humanize($content['Content']['object_type']); ?>
                    </div>
                    <div style="margin-left: 60px;">
                        <strong><?php echo $this->Html->link($content['Content']['title'], 
                                $content['Content']['url']); ?> </strong>
                        <div class="status-details">
                            <div class="tease">
                                <?php echo Scrub::html($this->Text->truncate($content['Content']['body'], 180)); ?>
                            </div>
                        </div>
                    </div>
                </div>            
            <?php endforeach; ?> 
            <?php echo $this->element('paginate'); ?>
        </div>        
    </div>
    
    <div class="one-third column omega">
        
        <?php 
            echo $this->element(
                    'Blocks' . DS . 'hcard', 
                    array(
                            'userProfile'=>$userProfile, 
                            'allOpen'=>true,
                            'h1'=>true
                        )
                    ); 
            

        
            //Privides navigation for manageing an asset
            if($mine):

                //If it's your post you'll be provided CMS links
                $additional = array(
                    array(
                        'text'=>"Edit Profile",
                        'url'=>"/profiles/edit/{$profileId}",
                        'options' => array(),
                        'confirm'=>null
                    )               
                );
                        
                echo $this->element('Navigation' . DS . 'manage', 
                            array('section'=>'profile', 
                                'additional'=>$additional
                            )
                        );
            endif; 
        ?>

    </div>
    
</div>