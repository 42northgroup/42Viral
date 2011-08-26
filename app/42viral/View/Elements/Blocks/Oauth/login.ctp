<style type="text/css">
    .oauth-button{
        padding: 2px 2px 1px 18px;
        line-height:20px;
        text-decoration: none;
        color:#333;
    }
    
    .horizontal .oauth-button{
        margin: 0 6px 0 0;
    }       
    
    .vertical .oauth-button{
        display: block;
    }   
    
    .linkedin{
        background: url('/img/icons/linkedin.png') no-repeat 0 1px;
    }
    
    
    .twitter{
        background: url('/img/icons/twitter.png') no-repeat 0 1px;
    }
    
    
    .facebook{
        background: url('/img/icons/facebook.png') no-repeat 0 1px;
    }    
</style>


<?php
    echo $this->Html->link('Sign in with LinkedIn', '/oauth/linkedin_connect', array('class'=>'oauth-button linkedin'));
    echo $this->Html->link('Sign in with FaceBook', '/oauth/facebook_connect', array('class'=>'oauth-button facebook'));
    echo $this->Html->link('Sign in with Twitter', '/oauth/twitter_connect', array('class'=>'oauth-button twitter'));
?>
