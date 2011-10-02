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



echo $this->Form->create('Content', array(
    'url' => $this->here,
    'class'=>'search'
    ));
?>

<div class="clearfix">
    <?php
echo $this->Form->input('title', array('style'=>'width: 254px;', 'type'=>'text'));

echo $this->Form->input('body', array('style'=>'width: 254px;', 'type'=>'text'));

echo $this->Form->input('tags', array('style'=>'width: 254px;', 'type'=>'text'));
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
<?php
echo $this->Form->submit(__('Search'));
echo $this->Form->end();

if($display == 'results'):
?>


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
    echo $this->element('paginate');
    
    endif;