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
                'Address',
                array(
                    'url'=>$this->here,
                    'class'=>'responsive'
                )
            );

            echo $this->Form->input('id');
            echo $this->Form->input(
                'type',
                array(
                    'options'=>$addressTypes,
                    'type'=>'radio'
                )
            );
            echo $this->Form->input('label');
            echo $this->Form->input('line1');
            echo $this->Form->input('line2');
            echo $this->Form->input('city');
            echo $this->Form->input(
                'state',
                array(
                    'empty'=>true
                )
            );
            echo $this->Form->input('zip');
            echo $this->Form->input(
                'country',
                array(
                    'options'=>$contries
                )
            );
            //echo $this->Form->input('latitude');
            //echo $this->Form->input('longitude');
            echo $this->Form->submit();

            echo $this->Form->end();

        ?>
    </div>
    <div class="one-third column omega">
        <?php echo $this->element('Navigation' . DS . 'menus', array('section'=>'address')); ?>
    </div>
</div>
