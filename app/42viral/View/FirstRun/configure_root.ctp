<h1>Configure the system's root user</h1>
<?php

    echo $this->Form->create('User', 
                array(
                    'url'=>$this->here, 
                    'class'=>'default'
                )
            );
    echo $this->Form->input('id', array('value'=>'4e27efec-ece0-4a36-baaf-38384bb83359'));
    echo $this->Form->input('email');
    echo $this->Form->input('password');
    echo $this->Form->input('verify_password', array('type'=>'password'));
    
    echo $this->Form->submit();
    echo $this->Form->end();

?>
