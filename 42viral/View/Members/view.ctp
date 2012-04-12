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
        border-left: 1px solid #3B5998;
    }
    
    .google_plus-post{
        padding: 5px 5px 15px 5px;
        border-left: 1px solid #000;
    }
    
    .twitter-post{
        padding: 5px 5px 15px 5px;
        border-left: 1px solid #4099FF;
    }
    
    .linkedin-post{
        padding: 5px 5px 15px 5px;
        border-left: 1px solid #006699;
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
        <div id="ResultsPage">
            <h2><?php echo $this->Member->name($userProfile['Person']); ?>'s Content</h2>
            
            <?php foreach($userProfile['Content'] as $content):?>
            <div class="result">
                <div class="clearfix">
                    <h2 style="float:left;"><?php echo $this->Html->link($content['title'], $content['url']); ?> </h2>
                    <div style="float:right; font-style: italic;">
                        <?php echo Inflector::humanize($content['object_type']); ?></div>
                </div>
                <div class="tease"><?php echo $this->Text->truncate($content['title'], 180); ?></div>
            </div>
            <?php endforeach; ?>
            
            <h2>Social Media Stream</h2>

            <?php 
            if( isset($statuses['connection']) ):
                foreach($statuses['connection'] as $key => $val):
                    echo $key . __(' does not seem to be responding, please try again later.') . '<br/>';
                endforeach;
            endif; 
            ?>

            <?php foreach ($statuses['posts'] as $status): ?>

                <?php if($status['post'] != ''): ?>
                <div class="clearfix status">
                    <div style="float:left; width: 40px;">
                    <?php 
                        echo $this->Html->image(
                                "/img/graphics/social_media/production/{$status['source']}32.png"); 
                    ?>
                    </div>
                    <div style="float:left; width: 510px;" class="<?php echo $status['source'].'-post'; ?>">
                        <?php echo $this->Html->div(null, $status['post']); ?>
                        <div class="status-details">
                            <?php echo isset($status['time'])? date('F jS \a\t h:ia', $status['time']):''; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            <?php endforeach;?>            

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