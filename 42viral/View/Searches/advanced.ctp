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

echo $this->Form->create('Content', array(
    'url' => $this->here,
    'class'=>'search',
    'style'=>"border-bottom: 1px solid #EFEFEF; padding: 0 0 4px; margin: 0 0 6px;"
    ));
?>

<div class="clearfix">
<?php

    echo $this->Form->input('title', array('style'=>'width: 240px; margin-right: 8px;', 'type'=>'text'));

    echo $this->Form->input('body', array('style'=>'width: 240px;', 'type'=>'text'));

    echo $this->Form->input('tags', array('style'=>'width: 240px; margin-right: 8px;', 'type'=>'text'));
?>
</div>
<div class="clearfix">
<?php
echo $this->Form->input('object_type', 
        array(
            'multiple' => 'checkbox',
            'div'=>array('style'=>'margin-right:20px;')
            ));

echo $this->Form->input('status', 
        array(
            'multiple' => 'checkbox'
            ));
?>
</div>    
<div class="clearfix">
<?php
echo $this->Html->link('Simple Search', '/searches', array('style'=>'float:left; margin:19px 0 0;'));
echo $this->Form->submit(__('Search'), array('div'=>array('float:right;')));
?>
</div>
<?php 
echo $this->Form->end();
if($display == 'results'):
 

    if(!empty($data)): ?>
        <div id="ResultsPage">
            <?php foreach($data as $content): ?>

            <div class="result">


                <div class="clearfix">

                    <h2 style="float:left;">
                        <?php echo $this->Html->link($content['Content']['title'], $content['Content']['url']); ?> </h2>

                    <div style="float:right; font-style: italic;">
                        <?php echo Inflector::humanize($content['Content']['object_type']); ?></div>

                </div>

                <div class="tease"><?php echo $this->Text->truncate($content['Content']['tease'], 180); ?></div>

            </div>
            <?php endforeach; ?>

        </div>
    <?php
       // echo $this->element('paginate');


    else:
        echo $this->element('no_results', array('message'=>__("I'm sorry, there are no results to display.")));
    endif;

else:
    echo $this->element('no_results', array('message'=>__("I'm sorry, there are no results to display.")));
endif;