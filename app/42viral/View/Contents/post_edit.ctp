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
 * @author Jason D Snider <jsnider77@gmail.com>
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

<h1>Edit your blog post</h1>

<?php

    echo $this->Form->create('Post', 
                array(
                    'url'=>$this->here, 
                    'class'=>'content'
                )
            );
    echo $this->Form->input('id');
    echo $this->Form->input('title', array('rows'=>1, 'cols'=>96));
    echo $this->Form->input('canonical', array('rows'=>2, 'cols'=>96));
    echo $this->Form->input('body', array('class'=>'edit-basic'));
    echo $this->Form->input('tease', array('class'=>'edit-basic'));
    echo $this->Form->input('description', array('rows'=>6, 'cols'=>96));
    echo $this->Form->input('keywords', array('rows'=>6, 'cols'=>96));
    echo $this->Form->input('custom_file', array('empty'=>true));   
    echo $this->Form->input('canonical', array('rows'=>2, 'cols'=>96));
    echo $this->Form->input('slug', array('rows'=>2, 'cols'=>96));
    echo $this->Form->input('status');
    echo $this->Form->submit();
    echo $this->Form->end();

?>