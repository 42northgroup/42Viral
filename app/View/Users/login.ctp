<h1>Login</h1>
<?php
    
    echo $this->Form->create('User', 
            array(
                'url'=>$this->here,
                'class'=>'default'
            
            ));
    
    echo $this->Form->input('username');
    echo $this->Form->input('password');
    
    echo $this->Form->submit();
    echo $this->Form->end();

?>
