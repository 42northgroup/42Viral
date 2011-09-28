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
 * @package app
 * @package app.core
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
?>

<?php
    $this->Asset->addAssets(array(
        'js/vendors/ckeditor/adapters/42viral.js',
        'js/vendors/ckeditor/ckeditor.js',
        'js/vendors/ckeditor/adapters/jquery.js'
    ), 'ck_editor');

    echo $this->Asset->buildAssets('js', 'ck_editor', false);
?>

<h1>Notification - Edit</h1>

<div class="">
    <a href="/notification/index">Index<a/>
    /
    <a href="/notification/create">Create<a/>
</div>

<?php
echo $this->Form->create('Notification', array(
    'url' => $this->here,
    'class' => 'content'
));
?>

<?php echo $this->Form->input('id'); ?>

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

<?php echo $this->Form->submit('Update'); ?>

<?php echo $this->Form->end(); ?>
