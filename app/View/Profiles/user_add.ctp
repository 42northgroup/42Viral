<?php

    echo $this->Form->create('User', array('url'=>$this->here));
    
    echo $this->Form->input('email');
    echo $this->Form->input('username');
    echo $this->Form->input('password');
    
    echo $this->Form->submit();
    echo $this->Form->end();

?>
