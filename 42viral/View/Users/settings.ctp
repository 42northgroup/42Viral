<?php echo $this->element('Navigation' . DS . 'local', array('section'=>''));  ?>


<h2>Change Password</h2>

<?php 
echo $this->Form->create('Person', 
        array(
            'url' => '/users/change_password',
            'class'=>'default'
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
