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

            <?php echo $this->Form->create('Upload',
                    array(
                        'class'=>'responsive',
                        'url' => $this->here,
                        "enctype" => "multipart/form-data")); ?>
            <?php echo $this->Form->input('file', array('type' => 'file')); ?>
            <?php echo $this->Form->input('label'); ?>
            <?php echo $this->Form->submit('Upload'); ?>
            <?php echo $this->Form->end(); ?>

    </div>
</div>