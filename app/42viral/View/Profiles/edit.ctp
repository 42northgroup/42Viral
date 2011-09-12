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
 * @author Jason D Snider <jsnider77@gmail.com>
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */

    $this->Asset->addAssets(array(
        'js/vendors/ckeditor/adapters/42viral.js',
        'js/vendors/ckeditor/ckeditor.js',
        'js/vendors/ckeditor/adapters/jquery.js'
    ), 'ck_editor');

    echo $this->Asset->buildAssets('js', 'ck_editor', false);
?>

<h1>Update your profile</h1>
<?php 

echo $this->Form->create('Profile', array(
    'action' => 'save',
    'class'=>'content'
));

echo $this->Form->input('id');

echo $this->Form->input('owner_person_id', array('type'=>'hidden', 'value'=>$this->Session->read('Auth.User.id')));

echo $this->Form->input('Person.id', array('value'=>$this->Session->read('Auth.User.id')));
echo $this->Form->input('Person.first_name');
echo $this->Form->input('Person.last_name');

echo $this->Form->input('tease', array('class' => 'edit-basic'));

echo $this->Form->submit('Submit');

echo $this->Form->end();

?>