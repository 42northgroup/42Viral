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

<script type="text/javascript">
$(function() {
    $('#NotificationAlias').focus();
});
</script>

<?php echo $this->Asset->buildAssetPackage('ck_editor'); ?>

<h1><?php echo $title_for_layout; ?></h1>

<?php echo $this->element('Navigation' . DS . 'local', array('section'=>'notifications'));?>


<?php
echo $this->Form->create('Notification', array(
    'url' => $this->here,
    'class'=>'responsive'
));
?>

<?php echo $this->Form->input('alias'); ?>

<?php echo $this->Form->input('name'); ?>

<?php echo $this->Form->input('subject_template'); ?>

<?php
echo $this->Form->input('body_template', array(
    'class' => 'edit-content'
));
?>

<?php
echo $this->Form->input('active', array(
    'checked' => true
));
?>

<?php echo $this->Form->submit('Create'); ?>

<?php echo $this->Form->end(); ?>