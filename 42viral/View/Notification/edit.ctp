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

<?php
    $this->Asset->addAssets(array(
        'vendors' . DS . 'ckeditor' . DS . 'adapters' . DS . '42viral.js',
        'vendors' . DS . 'ckeditor' . DS . 'ckeditor.js',
        'vendors' . DS . 'ckeditor' . DS . 'adapters' . DS . 'jquery.js'
    ), 'ck_editor');

    echo $this->Asset->buildAssets('js', 'ck_editor', false);
?>

<?php 

$additional  = array(
    array(
        'text'=>"View",
        'url'=>"/notification/view/{$notification['Notification']['id']}",
        'options' => array(),
        'confirm'=>null
    ),
    array(
        'text'=>"Delete",
        'url'=>"/notification/delete/{$notification['Notification']['id']}",
        'options' => array(),
        'confirm'=>'Are you sure you want to delete this? \n This action CANNOT be reversed!'
    ),
    array(
        'text'=>"Test Fire",
        'url'=>"/notification/test/{$notification['Notification']['id']}",
        'options' => array(),
        'confirm'=>null
    )
);

echo $this->element('Navigation' . DS . 'local', array('section'=>'notifications', 'additional' => $additional)); 
?>


<?php
echo $this->Form->create('Notification', array(
    'url' => $this->here,
    'class'=>'responsive'
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