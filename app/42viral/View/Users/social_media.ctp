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
                      
            $("#tweet-chars-left").html( tweet_chars_left );
        })
        
        $("#SocialMediaTwitter").keyup(function(){
            var tweet_chars_left = 140 - $("#SocialMediaTwitter").val().length;
                      
            $("#tweet-chars-left").html( tweet_chars_left );
            
        });

    });
</script>

<h1>Social Media</h1>

<?php  echo $this->Form->create('SocialMedia', array('url' => '/users/socialize')); ?>


    
<div style="width:100%; float: left; margin-bottom: 20px;">

    Your Message<br/>
    <?php echo $this->Form->input('message', array(
        'type'=>'textarea',
        'label'=>false,
        'style'=>'width:100%'
        )); ?>
</div>

<div style="width:100%; float: left; margin-bottom: 20px;">

    <?php echo $this->Form->input('twitter_post', array(
        'type' => 'checkbox', 
        'label' => 'Tweet'
        )); ?>

    <?php echo $this->Form->input('twitter', array(
        'type'=>'textarea',
        'maxlength' => 140,
        'label'=>false,
        'style'=>'width:100%'
        )); ?>

    Characters left: <span id="tweet-chars-left" >140</span>
</div>

<div style="width:100%; float: left;">

    <div style="float: left; width: 12%" >
        <?php echo $this->Form->input('facebook_post', array(
            'type' => 'checkbox', 
            'label' => 'Facebook'
            )); ?>
    </div>

    <div style="float: left; width: 12%" >
        <?php echo $this->Form->input('linkedin_post', array(
            'type' => 'checkbox', 
            'label' => 'LinkedIn'
            )); ?>
    </div>

    <?php echo $this->Form->input('others', array(
        'type'=>'textarea',
        'label'=>false,
        'style'=>'width:100%'            
        )); ?>
</div>

<div style=" float: right; margin-top: 10px;">
    
    <?php echo $this->Form->submit('Submit', array('style' => 'float: right')) ?>
    
</div>

<?php echo $this->Form->end(); ?>