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

<h1><?php echo $this->Member->displayName($userProfile['Person']) ?>'s Photo Stream</h1>
<?php echo $this->element('Blocks' . DS . 'Sub' . DS . 'profileNavigation'); ?>

<div class="clearfix">
    <?php foreach($user['Upload'] as $upload):?>
    <div style="float:left; padding: 6px; background: #efefef; border: 1px solid #dedede; margin: 8px 8px 0 0;">
            

            <?php 
                
                echo $this->Upload->img($upload);   
                echo $this->Html->tag('span',
                        $this->Text->truncate($upload['name'], 20),
                        array('title'=>$upload['name'])
                        );
            ?>
            

    </div>
    <?php endforeach; ?>
</div>

<hr />

<?php if($mine): ?>
   <h2>Upload a new image</h2>
    <?php echo $this->Form->create('Member', 
            array('url'=>'/uploads/image_upload', "enctype"=>"multipart/form-data")); ?>
    <?php echo $this->Form->input('Image.file', array('type'=>'file')); ?>
    <?php echo $this->Form->submit(); ?>
    <?php echo $this->Form->end(); ?>
<?php endif; ?>
