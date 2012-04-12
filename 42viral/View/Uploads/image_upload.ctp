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
    <div class="sixteen columns alpha omega">
        <?php
            echo $this->Upload->img($upload);

            echo $this->Html->tag(
                'span',
                $this->Text->truncate($upload['name'], 20),
                array(
                    'title' => $upload['name'],
                    'class' => 'image-title'
                )
            );
        ?>
        <?php echo $this->Form->input('Image.file', array('type'=>'file')); ?>
        <?php echo $this->Form->submit(); ?>
        <?php echo $this->Form->end(); ?>
    </div>
</div>