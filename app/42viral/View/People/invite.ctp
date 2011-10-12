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

<?php
    $this->Asset->addAssets(array(
        'js/vendors/ckeditor/adapters/42viral.js',
        'js/vendors/ckeditor/ckeditor.js',
        'js/vendors/ckeditor/adapters/jquery.js'
    ), 'ck_editor');

    echo $this->Asset->buildAssets('js', 'ck_editor', false);
?>

<?php
echo $this->Form->create('Invite', array(
    'url' => $this->here,
    'class' => 'content'
));
?>

<?php echo $this->Form->input('emails', array(
    'label' => 'Emails (type in email addresses of friends you want invite, separated by comma)'
)); ?>

<?php
echo $this->Form->input('message', array(
    'class' => 'edit-content',
    'type' => 'textarea',
    'value' => $this->Session->read('Auth.User.name').' has invited you to join the 42 Viral Project.'
));
?>

<?php echo $this->Form->submit('Send'); ?>

<?php echo $this->Form->end(); ?>