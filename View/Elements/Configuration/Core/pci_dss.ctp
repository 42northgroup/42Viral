<?php
/**
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

    echo $this->Form->inputs(array(
            'legend'=>'Brute Force Protection',

            'Loginattempts.id'=>array('value'=>'Login.attempts', 'type'=>'hidden'),
            'Loginattempts.value'=>array(
                'label'=>array(
                    'text'=>'Login Attempts Allowed',
                    'class'=>'help',
                    'title'=>'How many time can the user get their login credentials wrong, before they are locked'.
                                                                                                ' out of the system.'
                )
            ),

            'Loginlockout.id'=>array('value'=>'Login.lockout', 'type'=>'hidden'),
            'Loginlockout.value'=>array(
                'label'=>array(
                    'text'=>'Login Lockout Duration',
                    'class'=>'help',
                    'title'=>'When a user gets locked out of the system, how long will they be locked out for.'
                )
            ),
    ));
    
    echo $this->Form->inputs(array(
        'legend'=>'Password Hardening',
            'Passwordexpiration.id'=>array('value'=>'Password.expiration', 'type'=>'hidden'),
            'Passwordexpiration.value'=>array(
                'label'=>array(
                    'text'=>'Password Expiration(days)',
                    'class'=>'help',
                    'title'=>'How many days should a password be valid for.'
                )
            ),

            'PasswordminLength.id'=>array('value'=>'Password.minLength', 'type'=>'hidden'),
            'PasswordminLength.value'=>array(
                'label'=>array(
                    'text'=>'Password Minimum Length',
                    'class'=>'help',
                    'title'=>'The mininum number of characters required for a password.'
                )
            ),

            'Passwordalphanumeric.id'=>array('value'=>'Password.alphanumeric', 'type'=>'hidden'),
            'Passwordalphanumeric.value'=>array(
                'label'=>array(
                    'text'=>'Force Alphanumeric Password',
                    'class'=>'help',
                    'title'=>'Should the password contain numbers.'
                ),
                'type'=>'checkbox',
            ),

            'PasswordspecialChars.id'=>array('value'=>'Password.specialChars', 'type'=>'hidden'),
            'PasswordspecialChars.value'=>array(
                'label'=>array(                        
                    'text'=>'Force Special Chraracters Password',
                    'class'=>'help',
                    'title'=>'Should the password contain special characters.'
                ),
                'type'=>'checkbox'
            ),

            'Passworddifference.id'=>array('value'=>'Password.difference', 'type'=>'hidden'),
            'Passworddifference.value'=>array(
                'label'=>array(
                    'text'=>'New Password Difference',
                    'class'=>'help',
                    'title'=>'When the user is forced to change their password, how many different passwords must '.
                                                    'they use, before they can reuse one of their previous passwords.'
                )
            )

        ));
