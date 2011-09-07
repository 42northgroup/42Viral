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

<h1><?php echo $this->Member->displayName($userProfile['Person']) ?>'s Media Stream</h1>
<?php echo $this->element('Blocks' . DS . 'Sub' . DS . 'profileNavigation'); ?>

<table>
    <caption>Images</caption>
    <thead>
        <tr>
            <th>Type</th>
            <th>Name</th>
            <?php if($mine): ?>
                <th>Actions</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
    <?php foreach($user['Upload'] as $upload):?>
        <tr>
            <td>
                <?php echo Inflector::humanize($upload['object_type']); ?>
            </td>
            <td>
               <?php echo $this->Html->link($upload['name'], $upload['url']); ?>
            </td>
            <?php if($mine): ?>
            <td>
               <?php echo $this->Html->link('Set Avatar',
                       "/uploads/set_avatar/{$user['User']['id']}/{$upload['id']}"); ?>
            </td>
            <?php endif; ?>

        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php if($mine): ?>
    <?php echo $this->Form->create('Member', 
            array('url'=>'/uploads/image_upload', "enctype"=>"multipart/form-data")); ?>
    <?php echo $this->Form->input('Image.file', array('type'=>'file')); ?>
    <?php echo $this->Form->submit(); ?>
    <?php echo $this->Form->end(); ?>
<?php endif; ?>
