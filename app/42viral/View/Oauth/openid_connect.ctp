<?php 
    if (isset($error)) {
        echo '<p class="error">'.$error.'</p>';
    }
    echo $this->Form->create('User', array('url' => '/oauth/openid_connect'));
    echo $this->Form->input('OpenidUrl.openid', array('label' => false));
    echo $this->Form->end('Login');
?>