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

App::uses('Handy', 'Lib');
?>
<?php
$this->Asset->addAssets(array(
    'vendors' . DS . 'ckeditor' . DS . 'adapters' . DS . '42viral.js',
    'vendors' . DS . 'ckeditor' . DS . 'ckeditor.js',
    'vendors' . DS . 'ckeditor' . DS . 'adapters' . DS . 'jquery.js'
), 'ck_editor');

echo $this->Asset->buildAssets('js', 'ck_editor', false);
?>
<h1><?php echo $title_for_layout; ?></h1>
<div class="row">
    <div class="two-thirds column alpha">
        <?
        echo $this->Form->create('Profile', array(
            'action' => 'save',
            'class'=>'responsive'
        ));

        echo $this->Form->input('id');

        echo $this->Form->input('owner_person_id',
                array('type'=>'hidden', 'value'=>$this->Session->read('Auth.User.id')));

        echo $this->Form->input('Person.id', array('value'=>$this->Session->read('Auth.User.id')));

        echo $this->Form->input('Person.first_name');
        echo $this->Form->input('Person.last_name');

        echo $this->Form->input('bio', array('rows' => 2));

        echo $this->Form->submit('Submit');

        echo $this->Form->end();
        ?>
    </div>

    <div class="one-third column omega">
        <?php echo $this->element('Navigation' . DS . 'menus', array('section'=>'manage_profile')); ?>
    </div>

</div>


