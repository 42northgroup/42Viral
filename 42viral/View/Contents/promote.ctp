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
<h1><?php echo $title_for_layout; ?></h1>

<script type="text/javascript">
    $(function(){
        
        $("#SocialMediaMessage").keyup(function(){
            if($("#SocialMediaMessage").val().length <= 140){
                
                $("#SocialMediaTwitter").val($("#SocialMediaMessage").val());
            }else{
                var excess = $("#SocialMediaMessage").val().length - 140;
                var twitter = $("#SocialMediaMessage").val();
                
                
                $("#SocialMediaTwitter").val(twitter.substring(0, $("#SocialMediaMessage").val().length - excess));
            }
            
            $("#SocialMediaOthers").val($("#SocialMediaMessage").val());
            
            var tweet_chars_left = 140 - $("#SocialMediaTwitter").val().length;
                      
            $("#TweetCharsLeft").html( tweet_chars_left );
        })
        
        $("#SocialMediaTwitter").keyup(function(){
            var tweet_chars_left = 140 - $("#SocialMediaTwitter").val().length;
                      
            $("#TweetCharsLeft").html( tweet_chars_left );
            
        });

    });
</script>

<h1><?php echo $title_for_layout; ?></h1>

<div class="row">
    <div class="two-thirds column alpha">

    <?php  echo $this->Form->create('SocialMedia', 
            array(
                'url' => '/contents/promote',
                'class'=>'responsive'
                )); ?>

    <?php echo $this->Form->input('twitter_post', array(
        'type' => 'checkbox', 
        'label' => 'Twitter'
        )); ?>

    <?php echo $this->Form->input('twitter', array(
        'type'=>'textarea',
        'maxlength' => 140,
        'label'=>false,
        'value' => $promo['twitter']
        )); ?>
    Characters left: <span id="TweetCharsLeft" >140</span>

    <div class="clearfix">
        <?php echo $this->Form->input('facebook_post', array(
            'type' => 'checkbox', 
            'label' => 'Facebook',
            'div'=>array('style'=>'float:left; width:80px;')
            )); ?>

        <?php echo $this->Form->input('linkedin_post', array(
            'type' => 'checkbox', 
            'label' => 'LinkedIn',
            'div'=>array('style'=>'float:left; width:78px;')
            )); ?>
    </div>

    <?php echo $this->Form->input('others', array(
        'type'=>'textarea',
        'label'=>false,
        'value' => $promo['other']
        )); ?>

    <?php echo $this->Form->submit('Submit', array('style' => 'float: right')) ?>

    <?php echo $this->Form->end(); ?>
    </div>
    <div class="one-third column omega"></div>
</div>