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

<script type="text/javascript">
$(function() {
    $('#UserEmail').focus();
});
</script>

<h1><?php echo $title_for_layout; ?></h1>

<div class="row">
    <div class="four columns alpha">
        <?php
            echo $this->Form->create('User', 
                        array(
                            'url'=>$this->here, 
                            'class'=>'responsive'
                        )
                    );

            echo $this->Form->input('email');
            echo $this->Form->input('username');
            echo $this->Form->input('password');
            echo $this->Form->input('verify_password', array('type'=>'password'));

            if(Configure::read('Beta.private') == 1){ 
                echo $this->Form->input('invite', array('type'=>'text', 'value'=>$this->params['named']['invite']));
            }

            echo $this->Form->submit();
            echo $this->Form->end();
        ?>
    </div>

    <div class="four columns omega">
        <div class="block">
            <?php echo $this->Html->link('', "/oauth/google_connect", array('class'=>'oauth-button google-plus')); ?>
            <?php echo $this->Html->link('', '/oauth/linkedin_connect', array('class'=>'oauth-button linkedin')); ?>
            <?php echo $this->Html->link('', '/oauth/facebook_connect', array('class'=>'oauth-button facebook')); ?>
            <?php echo $this->Html->link('', '/oauth/twitter_connect', array('class'=>'oauth-button twitter')); ?>
        </div>
    </div>
    
</div>
