<h1><?php echo $title_for_layout; ?></h1>

<div class="row">
    <div class="four columns alpha omega">
        <?php

        echo $this->Form->create('Person', array(
            'url'=>$this->here,
            'class'=>'responsive'
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