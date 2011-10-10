<div style=" width: 290px; text-align: right;">
    <h2>Reset Password</h2>

    <?php
    echo $this->Form->create(
        'Person',
        array(
            'url' => "/users/pass_reset/{$reset_token}"
        )
    );

    echo $this->Form->input('id', array(
        'type' => 'hidden',
        'value' => $user_id
    ));

    echo $this->Form->input('password', array(
        'style' => 'margin-bottom: 5px;'
    ));

    echo $this->Form->input('verify_password', array(
        'label' => 'Verify Password',
        'type' => 'password',

        'style' => 'margin-bottom: 5px;'
    ));

    echo $this->Form->submit();

    echo $this->Form->end();
    ?>
</div>