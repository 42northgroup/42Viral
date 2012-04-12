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
        echo $this->Form->create('Content', array(
            'url' => $this->here,
            'class'=>'responsive'
            ));


        echo $this->Form->input('title', array('type'=>'text'));

        echo $this->Form->input('body', array('type'=>'text'));

        echo $this->Form->input('tags', array('type'=>'text'));

        echo $this->Form->input('object_type', 
                array(
                    'multiple' => 'checkbox',

                    ));

        echo $this->Form->input('status', 
                array(
                    'multiple' => 'checkbox'
                    ));

        echo $this->Form->submit(__('Search'));

        echo $this->Form->end();
        ?>
        <div class="block top">
            <?php echo $this->Html->link('Simple Search', '/searches'); ?>

        </div>
        
        <div class="block">
        <?php
        if($display == 'results'):
            if(!empty($data)): ?>
                <div id="ResultsPage">
                    <?php foreach($data as $content): ?>

                    <div class="result">


                        <div class="clearfix">

                            <h2 style="float:left;">
                                <?php echo $this->Html->link($content['Content']['title'], 
                                        $content['Content']['url']); ?> 
                            </h2>

                            <div style="float:right; font-style: italic;">
                                <?php echo Inflector::humanize($content['Content']['object_type']); ?></div>

                        </div>

                        <div class="tease"><?php echo $this->Text->truncate($content['Content']['tease'], 180); ?></div>

                    </div>
                    <?php endforeach; ?>

                </div>
            <?php
            else:
                echo $this->element('no_results', array('message'=>__("I'm sorry, there are no results to display.")));
            endif;

        else:
            echo $this->element('no_results', array('message'=>__("I'm sorry, there are no results to display.")));
        endif;
        ?>
        </div>
    </div>
    
    <div class="one-third column omega"></div>
    
</div>