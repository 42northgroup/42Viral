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

App::uses('Scrub', 'Lib');
?>
<h1><?php echo $title_for_layout; ?></h1>
<div class="row">
    <div class="two-thirds column alpha">

        <div id="ResultsPage">

                <?php
                if($showAll):

                    $nothing = empty($blogs)?true:false;
                    if(!$nothing):

                        foreach($blogs as $blog): ?>

                        <div class="result">
                            <div class="result-left">
                                <?php echo Inflector::humanize($blog['Blog']['object_type']); ?>
                            </div>
                            <div class="result-right">

                                <strong><?php echo $this->Html->link($blog['Blog']['title'],
                                        $blog['Blog']['url']); ?> </strong>

                                <div class="tease">
                                    <?php echo Scrub::noHtml(
                                            $this->Text->truncate(
                                                    $blog['Blog']['body'], 180, array('html' => true))); ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        endforeach;

                    else: ?>
                        <div class="no-results">
                            <div class="no-results-message">
                                <?php echo __("I'm sorry, there are no blogs to display."); ?>
                            </div>
                        </div>
              <?php endif;

                else:

                    $nothing = empty($blogs['Blog'])?true:false;

                    if(!$nothing):

                        foreach($blogs['Blog'] as $blog):
                        ?>
                        <div class="result">
                            <div class="result-left">
                                <?php echo Inflector::humanize($blog['Blog']['object_type']); ?>
                            </div>
                            <div class="result-right">

                                <strong><?php echo $this->Html->link($blog['Blog']['title'],
                                        $blog['Blog']['url']); ?> </strong>

                                <div class="tease">
                                    <?php echo Scrub::noHtml(
                                            $this->Text->truncate(
                                                    $blog['Blog']['body'], 180, array('html' => true))); ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        endforeach;

                    else:
                        echo __("This user hasn't created any blogs");
                    endif;

                endif;

                ?>

        </div>

    </div>
    <div class="one-third column omega">
        <?php echo $this->element('Navigation' . DS . 'menus', array('section'=>'blog')); ?>
    </div>
</div>