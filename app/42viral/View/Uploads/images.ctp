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
?>

<style type="text/css">
    .image-frame {
        /*float: left;*/
        display: inline-block;
        padding: 6px;
        background: #efefef;
        border: 1px solid #dedede;
        margin: 8px 4px 0 0;
        vertical-align: middle;
    }

    .image-title {
        overflow: hidden;
        width: 128px;
        display: block;
        margin-top: 5px;
        /*border: 1px solid red;*/
    }
</style>

<h1><?php echo $this->Member->displayName($userProfile['Person']) ?>'s Photo Stream</h1>
<?php echo $this->element('Blocks' . DS . 'Sub' . DS . 'profileNavigation'); ?>

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
<?php else: ?>
    <h3 style="text-align: center; margin: 20px;">No photos uploaded</h3>
<?php endif; ?>

<hr />

<?php if ($mine): ?>
    <h2>Upload a new image</h2>

    <?php echo $this->Form->create('Member', array('url' => '/uploads/image_upload', "enctype" => "multipart/form-data")); ?>
    <?php echo $this->Form->input('Image.file', array('type' => 'file')); ?>
    <?php echo $this->Form->submit('Upload'); ?>
    <?php echo $this->Form->end(); ?>
<?php endif; ?>
