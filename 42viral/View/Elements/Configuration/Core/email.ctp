<?php
echo $this->Form->inputs(array(
        'legend'=>'Email Settings',

        'Emailfrom.id'=>array('value'=>'Email.from', 'type'=>'hidden'),
        'Emailfrom.value'=>array(
            'label'=>array(
                'text'=>'From',
                'class'=>'help',
                'title'=>'When the systems sends an email, what do you want appear in the "From" field'
            ),
            'div'=> array('class'=>'input required')
        ),

        'EmailreplyTo.id'=>array('value'=>'Email.replyTo', 'type'=>'hidden'),
        'EmailreplyTo.value'=>array(
            'label'=>array(
                'text'=>'Reply To',
                'class'=>'help',
                'title'=>'When the systems sends an email, what do you want appear in the "Reply To" field'
            ),
            'div'=> array('class'=>'input required')
        ),
    ));