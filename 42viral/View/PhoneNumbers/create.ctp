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
?>
<h1><?php echo $title_for_layout; ?></h1>

<div class="row">
    <div class="two-thirds column alpha">
        <?php

            echo $this->Form->create(
                'PhoneNumber',
                array(
                    'url'=>$this->here,
                    'class'=>'responsive'
                )
            );
            echo $this->Form->input('model', array('value'=>$model, 'type'=>'hidden'));
            echo $this->Form->input('model_id', array('value'=>$modelId, 'type'=>'hidden'));
            echo $this->Form->input(
                'type',
                array(
                    'options'=>$listPhoneNumberTypes,
                    'type'=>'radio'
                )
            );
            echo $this->Form->input('label');
            echo $this->Form->input('access');
            echo $this->Form->input(
                'access',
                array(
                    'options'=>$listAccessTypes,
                    'type'=>'radio'
                )
            );
            echo $this->Form->submit();

            echo $this->Form->end();

        ?>
    </div>
    <div class="one-third column omega">
        <?php echo $this->element('Navigation' . DS . 'menus', array('section'=>'phone_number')); ?>
    </div>
</div>
