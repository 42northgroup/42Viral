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
        <?php echo $this->Form->create('Content', array(
            'url' => '/searches/tags',
            'class'=>'responsive',
            'style'=>"border-bottom: 1px solid #EFEFEF; padding: 0 0 4px; margin: 0 0 6px;"
            ));

        echo $this->Form->input('q', 
                array('type'=>'text', 'label'=>false));

        echo $this->Form->submit('Search', 
                array(
                    'div'=>array('style'=>'text-align:left;'), 'style'=>'padding: 5px 8px;'));
        ?>
        
        <div class="block top"></div>
       
        <?php
        echo $this->Form->end();

        if($display == 'results'):

            if(!empty($data)): ?>
                <div id="ResultsPage">
                    <?php foreach($data as $content): ?>
                        <div class="result">
                            <div class="result-left">
                                <?php echo Inflector::humanize($content['Content']['object_type']); ?>
                            </div>
                            <div class="result-right">

                                <strong><?php echo $this->Html->link($content['Content']['title'], 
                                        $content['Content']['url']); ?> </strong>

                                <div class="tease">
                                    <?php echo Scrub::noHtml(
                                            $this->Text->truncate(
                                                    $content['Content']['body'], 180, array('html' => true))); ?>
                                </div>
                            </div>
                        </div>   
                    <?php endforeach; ?>
                </div>
            <?php
                echo $this->element('paginate');

            else:
                echo $this->element('no_results', array('message'=>__("I'm sorry, there are no results to display.")));
            endif;

        else:
            echo $this->element('no_results', array('message'=>__("I'm sorry, there are no results to display.")));
        endif;
    ?>
    </div>
    <div class="one-third column omega">
        <?php echo $this->element('Blocks' . DS . 'tag_cloud'); ?>
    </div>
</div>