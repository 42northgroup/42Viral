<?php

    echo $this->Form->inputs(array(
            'legend'=>'Beta Mode',

            'BetaPrivate.id'=>array('value'=>'Beta.private', 'type'=>'hidden'),
            'BetaPrivate.value'=>array(
                'label'=>array(
                    'text'=>'New Members Can Only Join if Invited',
                    'class'=>'help',
                    'title'=>'If a person wants to register with 42Viral they need to get and invite from an '.
                                                                                                'existing user.'
                ),
                'type'=>'checkbox'
            ),

            'BetaInvitations.id'=>array('value'=>'Beta.invitations', 'type'=>'hidden'),
            'BetaInvitations.value'=>array(
                'label'=>array(
                    'text'=>'Number of Ivitations Per User (0 for inifinite)',
                    'class'=>'help',
                    'title'=>'How many invites is each user allowed to send.'
                )
            )
    ));
?>

