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
 * UI for creating a web page
 * @author Jason D Snider <jason.snider@42viral.org>
 */

    //echo $this->element('Navigation' . DS . 'local', array('section'=>'content'));    

    $this->Asset->addAssets(array(
        'vendors' . DS . 'ckeditor' . DS . 'adapters' . DS . '42viral.js',
        'vendors' . DS . 'ckeditor' . DS . 'ckeditor.js',
        'vendors' . DS . 'ckeditor' . DS . 'adapters' . DS . 'jquery.js'
    ), 'ck_editor');
?>
<div class="row">
    <div class="two-thirds column alpha">
    <?php
    echo $this->Asset->buildAssets('js', 'ck_editor', false);

    echo $this->Form->create('Blog', array(
        'url' => $this->here, 
        'class' => 'responsive',
        'type' => 'file'
    ));

    echo $this->Form->input('id');
    echo $this->Form->input('title', array('rows'=>1));
    echo $this->Form->input('tease', array('rows'=>2));
    ?>
        
    <div class="or-group">
        <h3>Load body content by uploading a file or typing in the editor:</h3>
        <div class="or-choice">
            <?php
            echo $this->Form->input('body_content_file', array(
                'type' => 'file',
                'label' => 'Upload from file'
            ));
            ?>
        </div>

        <h3>OR</h3>

        <div class="or-choice">
            <?php
            echo $this->Form->input('body', array(
                'class' => 'edit-content',
                'label' => 'Type'
            ));
            ?>
        </div>
    </div>
    <?php
    echo $this->Form->inputs(array(
                'legend'=>'Meta Data',
                'description'=>array('rows'=>3),
                'keywords' => array('rows'=>3),
                'tags'
                )
            );

    echo $this->Form->inputs(array(
            'legend'=>'SEO',
            'canonical'=>array('rows'=>1),
            'slug'=>array('rows'=>1)
            )
        );

    echo $this->Form->submit();
    echo $this->Form->end();
    ?>
    </div>
    <div class="one-third column omega"></div>
</div>