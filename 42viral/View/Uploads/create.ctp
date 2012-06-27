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
?>
<h1><?php echo $title_for_layout; ?></h1>

<div class="row">
    <div class="two-thirds column alpha">
    <?php
        echo $this->Form->create(
            'Upload',
            array(
                'class'=>'responsive',
                'url' => $this->here,
                "enctype" => "multipart/form-data"
            )
        );
        echo $this->Form->input(
            'model',
            array(
                'type'=>'hidden',
                'value'=>$model
            )
        );
        echo $this->Form->input(
            'model_id',
            array(
                'type'=>'hidden',
                'value'=>$modelId
            )
        );
        echo $this->Form->input('file',
            array(
                'type' => 'file'
            )
        );
        echo $this->Form->input('label');
        echo $this->Form->input(
            'description',
            array(
                'type'=>'textarea',
                'rows'=>1
            )
        );
        echo $this->Form->submit('Upload');
        echo $this->Form->end();
    ?>
    </div>
    <div class="one-third column omega"></div>
</div>