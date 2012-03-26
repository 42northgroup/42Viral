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
        <?php if(!empty($user['Upload'])): ?>
            <div class="clearfix">
                <?php foreach ($user['Upload'] as $upload): ?>
                    <div class="image-frame">
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


                    </div>
                <?php endforeach; ?>
            </div>
        <hr />
        <?php 
        else:
            echo $this->element('no_results', array('message'=>"This user has not uploaded any photos"));
        endif; 
        ?>



        <?php if ($mine): ?>
        <div class="block">
            <h2>Upload a new image</h2>

            <?php echo $this->Form->create('Member', 
                    array(
                        'class'=>'responsive',
                        'url' => '/uploads/image_upload', 
                        "enctype" => "multipart/form-data")); ?>
            <?php echo $this->Form->input('Image.file', array('type' => 'file')); ?>
            <?php echo $this->Form->submit('Upload'); ?>
            <?php echo $this->Form->end(); ?>
        </div>
        <?php endif; ?>
    </div>
</div>