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
<h1>Create Company Profile</h1>

<div class="company-create-form clearfix">
    <?php
    echo $this->Form->create('Company', array(
        'action' => 'save',
        'class'=> 'content'
    ));
    echo $this->Form->input('Company.id');
    echo $this->Form->input('Company.name');
    echo $this->Form->input('Company.body', array('class'=>'edit-content'));
    ?>

    <h3>Addresses:</h3>
    <?php
    if(!empty($this->data['Address'])):
        for($i=0; $i<count($this->data['Address']); $i++):
            echo $this->Form->input("Address.{$i}.id");
            echo $this->Form->input("Address.{$i}.line1");
            echo $this->Form->input("Address.{$i}.line2");
            echo $this->Form->input("Address.{$i}.city");
            echo $this->Form->input("Address.{$i}.state");
            echo $this->Form->input("Address.{$i}.zip");

            echo $this->Form->submit('Save');
            echo $this->Form->end();
        endfor;
    endif;
    ?>
</div>