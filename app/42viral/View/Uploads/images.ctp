<h1><?php echo $this->Member->displayName($user['User']); ?>'s Photo Album</h1>

<?php if($mine): ?>
    <?php echo $this->Form->create('Member', array("enctype"=>"multipart/form-data")); ?>
    <?php echo $this->Form->input('Image.file', array('type'=>'file')); ?>
    <?php echo $this->Form->submit(); ?>
    <?php echo $this->Form->end(); ?>
<?php endif; ?>