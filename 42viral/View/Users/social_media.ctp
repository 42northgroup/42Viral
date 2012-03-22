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

<div class="container">
    <div class="two-thirds column">
        <?php echo $this->element('Navigation' . DS . 'local', array('section'=>''));  ?>

        <?php  echo $this->Form->create('SocialMedia', 
                array(
                    'url' => '/users/socialize',
                    'class'=>'responsive'
                    )); ?>

        <?php echo $this->Form->input('message', array(
            'type'=>'textarea',
            'label'=>'Your Massage',
            )); ?>

        <?php echo $this->Form->input('twitter_post', array(
            'type' => 'checkbox', 
            'label' => 'Twitter'
            )); ?>

        <?php echo $this->Form->input('twitter', array(
            'type'=>'textarea',
            'maxlength' => 140,
            'label'=>false
            )); ?>
        Characters left: <span id="TweetCharsLeft" >140</span>

        <div class="clearfix">
            <?php echo $this->Form->input('facebook_post', array(
                'type' => 'checkbox', 
                'label' => 'Facebook'
                )); ?>

            <?php echo $this->Form->input('linkedin_post', array(
                'type' => 'checkbox', 
                'label' => 'LinkedIn'
                )); ?>
        </div>

        <?php echo $this->Form->input('others', array(
            'type'=>'textarea',
            'label'=>false         
            )); ?>

        <?php echo $this->Form->submit('Submit', array('style' => 'float: right')) ?>

        <?php echo $this->Form->end(); ?>
    </div>
    <div class="one-third column">

    </div>
</div>