<style type="text/css">
    .mediaIcon{
        margin: 10px 10px 5px 0;
        cursor: pointer;
    }
</style>

<script type="text/javascript">    
    var SocialMedia = {
        post: '',
        
        setup: function(){
            $("#SocialMediaMessage").keyup(function(){
            
                SocialMedia.post = $("#SocialMediaMessage").val();            

            }),

            $("#SocialMediaTwitter").keyup(function(){
                var tweet_chars_left = 140 - $("#SocialMediaTwitter").val().length;

                $("#TweetCharsLeft").html( tweet_chars_left );

            });

            $(".mediaIcon").click(function(){

                var glowColor = $(this).attr('data-color');
                var checkboxId = 'SocialMedia' + $(this).attr('id').replace('Icon', '') + 'Post';
                var frameId = $(this).attr('id').replace('Icon', '') + 'Frame';

                if($("#" + checkboxId).val() == 0){

                    $("#" + checkboxId).val(1);
                    $("#" + frameId).show();

                    $(this).css('box-shadow', '0 0 15px '+ glowColor +', inset 0 0 5px '+ glowColor);
                    $(this).css('border-radius', '3px');

                    if(checkboxId == 'SocialMediaTwitterPost'){

                        var excess = 0;
                        var tweet_chars_left = 140 - $("#SocialMediaMessage").val().length;

                        if(tweet_chars_left < 0){
                            excess = Math.abs(tweet_chars_left);
                            tweet_chars_left = 0;
                        }

                        var entirePost = SocialMedia.post;
                        $("#SocialMediaTwitter").val(
                                        SocialMedia.post.substring(0, $("#SocialMediaMessage").val().length - excess));
                                        
                        $("#TweetCharsLeft").html( tweet_chars_left );
                        SocialMedia.post = entirePost;
                    }else{

                        var textAreaId = checkboxId.replace('Post', '');
                        $("#" + textAreaId).val(SocialMedia.post);
                    }

                }else{

                    $("#" + checkboxId).val(0);
                    $("#" + frameId).hide();

                    $(this).css('box-shadow', '');
                    $(this).css('border-radius', '');
                }
            });
        }
        
        
    }
    
    $(function(){
        SocialMedia.setup();
    });
</script>

<h1><?php echo $title_for_layout; ?></h1>

<div class="row">
    <div class="two-thirds column alpha">

        <?php  echo $this->Form->create('SocialMedia', array(
            'url' => '/users/socialize',
            'class'=>'responsive'
        )); ?>

        <?php echo $this->Form->input('message', array(
            'type'=>'textarea',
            'label'=>'Your Massage',
        )); ?>

        <?php echo $this->Form->input('twitter_post', array(
            'value' => 0, 
            'label' => false,
            'div' => array('style' => 'display:none')
        )); ?>
        
        <?php echo $this->Html->image("/img/social_media_icons/social_networking_iconpack/twitter_32.png", array(
            'class' => 'mediaIcon',
            'data-color' => '#4099FF',
            'id' => 'TwitterIcon'
        )); ?>

        <div id="TwitterFrame" style="display: none" >
            <?php echo $this->Form->input('twitter', array(
                'type'=>'textarea',
                'maxlength' => 140,
                'label'=>false
            )); ?>

            Characters left: <span id="TweetCharsLeft" >140</span>
        </div>

        
        <?php echo $this->Form->input('facebook_post', array(
            'value' => 0, 
            'label' => 'Facebook',
            'div' => array('style' => 'display: none')
        )); ?>

        <?php echo $this->Html->image("/img/social_media_icons/social_networking_iconpack/facebook_32.png", array(
            'class' => 'mediaIcon',
            'data-color' => '#3B5998',
            'id' => 'FacebookIcon'
        )); ?>
        
        <div id="FacebookFrame" style="display: none" >
            <?php echo $this->Form->input('facebook', array(
                'type'=>'textarea',
                'label'=>false
            )); ?>

        </div>

        <?php echo $this->Form->input('linkedin_post', array(
            'value' => 0, 
            'label' => 'LinkedIn',
            'div' => array('style' => 'display:none')
        )); ?>

        <?php echo $this->Html->image("/img/social_media_icons/social_networking_iconpack/linkedin_32.png", array(
            'class' => 'mediaIcon',
            'data-color' => '#006699',
            'id' => 'LinkedinIcon'
        )); ?>
        

        <div id="LinkedinFrame" style="display: none" >
            <?php echo $this->Form->input('linkedin', array(
                'type'=>'textarea',
                'label'=>false
            )); ?>
        </div>

        <?php echo $this->Form->submit('Post', array('style' => 'float: right')) ?>
        
        <?php echo $this->Form->end(); ?>
    </div>
    <div class="one-third column omega"></div>
</div>