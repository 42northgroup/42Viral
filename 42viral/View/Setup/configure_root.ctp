<?php

/**
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 *** @author Jason D Snider <jason.snider@42viral.org>
 */

echo $this->element('Navigation' . DS . 'local', array('section'=>'configuration', 'class'=>'config'));

echo $this->Form->create('User', 
            array(
                'url'=>$this->here, 
                'class'=>'default'
            )
        );
echo $this->Form->input('id', array('value'=>'4e27efec-ece0-4a36-baaf-38384bb83359'));
echo $this->Form->input('email');
echo $this->Form->input('password');
echo $this->Form->input('verify_password', array('type'=>'password'));
echo $this->Form->input('employee', array('type'=>'hidden', 'value'=>1));

echo $this->Form->submit('Save Configuration', 
        array('before'=>$this->Form->input('Control.next_step', 
                array(
                    'type'=>'checkbox', 
                    'div'=>false, 
                    'style'=>'margin-right: 6px;',
                    'checked'=>true,
                    'label'=>array('style'=>'display:inline; margin-right: 6px;')))));

echo $this->Form->end();

?>
