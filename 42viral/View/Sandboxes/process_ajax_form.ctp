<?php
echo $this->Form->create(
    'Content',
    array(
        //'url'=>'/sandboxes/process_ajax_form/',
        'class'=>'responsive',
        'default'=>false

    )
);
?>
<?php echo $this->Form->input('title'); ?>
<?php echo $this->Form->submit('Submit', array('id'=>'ContentAjaxFormTrigger')); ?>
<?php echo $this->Form->end(); ?>

<?php echo 'the form has been reloaded'; ?>