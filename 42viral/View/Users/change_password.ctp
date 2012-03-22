<div class="clearfix">
    <div style="float:left;">
        <?php

        echo $this->Form->create('Person', array(
            'url'=>$this->here,
            'class'=>'default'
        ));

        echo $this->Form->input('id', array(
            'type' => 'hidden',
            'value' => $this->Session->read('Auth.User.id')
        ));
  
        echo $this->Form->input('password');
        echo $this->Form->input('verify_password', array(
            'type' => 'password'
        ));
        
        echo $this->Form->submit();
        echo $this->Form->end();
        ?>                
    </div>
</div>