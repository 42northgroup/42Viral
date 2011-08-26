<style type="text/css">
    .oauth-button{
        padding: 2px 2px 1px 18px;
        line-height:20px;
        text-decoration: none;
        color:#333;
        margin: 0 6px 0 0;
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


<h1>Create an Account</h1>
<div class="clearfix">
    <div style="float:left;">
<?php

    echo $this->Form->create('User', 
                array(
                    'url'=>$this->here, 
                    'class'=>'default'
                )
            );
    
    echo $this->Form->input('email');
    echo $this->Form->input('username');
    echo $this->Form->input('password');
    echo $this->Form->input('verify_password', array('type'=>'password'));
    
    echo $this->Form->submit();
    echo $this->Form->end();
?>
    </div>
    <div style="float:left; margin:0 0 0 8px">
    <?php    

        echo $this->Html->link('Sign in with LinkedIn', '/oauth/linkedin_connect', array('class'=>'oauth-button linkedin'));
        echo "<br>";
        echo $this->Html->link('Sign in with FaceBook', '/oauth/facebook_connect', array('class'=>'oauth-button facebook'));
        echo "<br>";
        echo $this->Html->link('Sign in with Twitter', '/oauth/twitter_connect', array('class'=>'oauth-button twitter'));

    ?>
    </div>
</div>



