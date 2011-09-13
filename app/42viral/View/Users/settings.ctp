<div class="clearfix">
    
    <h1 style="float:left;"><?php echo $this->Member->displayName($user['User']) ?>'s Settings</h1>
    
</div>

<div style=" width: 290px; text-align: right;">
    <h2>Change Password</h2>
    
    <?php 
    echo $this->Form->create('Person', array('url' => '/users/change_password'));
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