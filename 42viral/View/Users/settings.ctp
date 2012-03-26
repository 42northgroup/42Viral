<h1><?php echo $title_for_layout; ?></h1>

<div class="row">
    <div class="four columns alpha omega">
        <?php 
        echo $this->Form->create('Person', 
                array(
                    'url' => '/users/change_password',
                    'class'=>'responsive'
                    )
                );
        echo $this->Form->input('id', array(
            'type' => 'hidden',
            'value' => $this->Session->read('Auth.User.id')
            ));

        echo $this->Form->input('password', array('style' => 'margin-bottom: 5px;'));
        echo $this->Form->input('verify_password', array(
            'label' => 'Verify Password',
            'style' => 'margin-bottom: 5px;',
            'type' => 'password'
            ));
        echo $this->Form->submit();
        echo $this->Form->end();
        ?>  
    </div>
</div>
