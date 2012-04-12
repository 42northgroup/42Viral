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