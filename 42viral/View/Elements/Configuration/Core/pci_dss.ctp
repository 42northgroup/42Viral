<?php
    echo $this->Form->inputs(array(
            'legend'=>'Brute Force Protection',

            'LoginAttempts.id'=>array('value'=>'Login.attempts', 'type'=>'hidden'),
            'LoginAttempts.value'=>array(
                'label'=>array(
                    'text'=>'Login Attempts Allowed',
                    'class'=>'help',
                    'title'=>'How many time can the user get their login credentials wrong, before they are locked'.
                                                                                                ' out of the system.'
                )
            ),

            'LoginLockout.id'=>array('value'=>'Login.lockout', 'type'=>'hidden'),
            'LoginLockout.value'=>array(
                'label'=>array(
                    'text'=>'Login Lockout Duration',
                    'class'=>'help',
                    'title'=>'When a user gets locked out of the system, how long will they be locked out for.'
                )
            ),
    ));
    
    echo $this->Form->inputs(array(
        'legend'=>'Password Hardening',
            'PasswordExpiration.id'=>array('value'=>'Password.expiration', 'type'=>'hidden'),
            'PasswordExpiration.value'=>array(
                'label'=>array(
                    'text'=>'Password Expiration(days)',
                    'class'=>'help',
                    'title'=>'How many days should a password be valid for.'
                )
            ),

            'PasswordMinLength.id'=>array('value'=>'Password.minLength', 'type'=>'hidden'),
            'PasswordMinLength.value'=>array(
                'label'=>array(
                    'text'=>'Password Minimum Length',
                    'class'=>'help',
                    'title'=>'The mininum number of characters required for a password.'
                )
            ),

            'PasswordAlphanumeric.id'=>array('value'=>'Password.alphanumeric', 'type'=>'hidden'),
            'PasswordAlphanumeric.value'=>array(
                'label'=>array(
                    'text'=>'Force Alphanumeric Password',
                    'class'=>'help',
                    'title'=>'Should the password contain numbers.'
                ),
                'type'=>'checkbox',
            ),

            'PasswordSpecialChars.id'=>array('value'=>'Password.specialChars', 'type'=>'hidden'),
            'PasswordSpecialChars.value'=>array(
                'label'=>array(                        
                    'text'=>'Force Special Chraracters Password',
                    'class'=>'help',
                    'title'=>'Should the password contain special characters.'
                ),
                'type'=>'checkbox'
            ),

            'PasswordDifference.id'=>array('value'=>'Password.difference', 'type'=>'hidden'),
            'PasswordDifference.value'=>array(
                'label'=>array(
                    'text'=>'New Password Difference',
                    'class'=>'help',
                    'title'=>'When the user is forced to change their password, how many different passwords must '.
                                                    'they use, before they can reuse one of their previous passwords.'
                )
            )

        ));
