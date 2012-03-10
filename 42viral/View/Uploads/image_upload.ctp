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

echo $this->element('Navigation' . DS . 'local', array('section'=>''));
?>

<?php echo $this->Form->create('Member', 
        array('url'=>'/uploads/image_upload', "enctype"=>"multipart/form-data")); ?>
<?php echo $this->Form->input('Image.file', array('type'=>'file')); ?>
<?php echo $this->Form->submit(); ?>
<?php echo $this->Form->end(); ?>