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
 
?>
<h1><?php echo $title_for_layout; ?></h1>

<div class="row">
    <div class="two-thirds column alpha">
        <div id="ResultsPage">
            <?php foreach($userProfile['Content'] as $content):?>
            <div class="result">
                <div class="clearfix">
                    <h2 style="float:left;"><?php echo $this->Html->link($content['title'], $content['url']); ?> </h2>
                    <div style="float:right; font-style: italic;"><?php echo Inflector::humanize($content['object_type']); ?></div>
                </div>
                <div class="tease"><?php echo $this->Text->truncate($content['title'], 180); ?></div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>

    <div class="one-third column omega">
        <?php foreach($post['Conversation'] as $conversation): ?>
            <div><?php echo $conversation['body']; ?></div>
        <?php endforeach; ?>

        <?php echo $this->element('Posts' . DS . 'post_comments'); ?>
    </div>
</div>