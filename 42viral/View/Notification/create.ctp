<?php
    $this->Asset->addAssets(array(
        'vendors' . DS . 'ckeditor' . DS . 'adapters' . DS . '42viral.js',
        'vendors' . DS . 'ckeditor' . DS . 'ckeditor.js',
        'vendors' . DS . 'ckeditor' . DS . 'adapters' . DS . 'jquery.js'
    ), 'ck_editor');

    echo $this->Asset->buildAssets('js', 'ck_editor', false);
?>

<h1><?php echo $title_for_layout; ?></h1>

<?php echo $this->element('Navigation' . DS . 'local', array('section'=>'notifications'));?>


<?php
echo $this->Form->create('Notification', array(
    'url' => $this->here,
    'class' => 'content'
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