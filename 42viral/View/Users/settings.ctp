<script type="text/javascript">
$(function(){
    
    if($("#UserSettingPhoneNumberProtocolType").val() != ''){
        $("#UserSettingPhoneNumberProtocol").parent().show()
    }
    
    $("#UserSettingPhoneNumberProtocolType").change(function(){
        if($(this).val() != ''){
            $("#UserSettingPhoneNumberProtocol").parent().show()
        }else{
            $("#UserSettingPhoneNumberProtocol").parent().hide()
            $("#UserSettingPhoneNumberProtocol").val("");
        }
    });
});
</script>

<h1><?php echo $title_for_layout; ?></h1>

<div class="row">
    <div class="four columns alpha">
        <?php 
        echo $this->Form->create('UserSetting', 
                array(
                    'url' => '/users/settings',
                    'class'=>'responsive'
                    )
                );
        echo $this->Form->input('id', array(
            'type' => 'hidden'
        ));
        
        echo $this->Form->input('person_id', array(
            'value' => $userProfile['Person']['id'],
            'type' => 'hidden'
        ));

        echo $this->Form->inputs(array(
            'legend' => 'Settings',
            'phone_number_protocol_type' => array(
                'style' => 'margin-bottom: 5px;',
                'options' => array(
                    null => '',
                    'dialer' => 'Dialer',
                    'mobile_dialer' => 'Mobile Dialer'
                )
            ),
            'phone_number_protocol' => array(
                'style' => 'margin-bottom: 5px;',
                'div' => array('style' => 'display: none;')
            )
        ));
        
        echo $this->Form->submit('Save Settings', array(
            'div' => array('style' => 'float:right')
        ));
        echo $this->Form->end();
        ?>  
    </div>
    <div class="two columns">
        &nbsp;
    </div>
    <div class="four columns omega">
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

        echo $this->Form->inputs(array(
            'legend' => 'Change Password',
            'password' => array('style' => 'margin-bottom: 5px;'),
            'verify_password' => array(
                'label' => 'Verify Password',
                'style' => 'margin-bottom: 5px;',
                'type' => 'password'
            )
        ));
        
        echo $this->Form->submit('Save Password', array(
            'div' => array('style' => 'float:right')
        ));
        echo $this->Form->end();
        ?>  
    </div>
</div>
