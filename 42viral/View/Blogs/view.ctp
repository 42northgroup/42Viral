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
        <div>
            <?php 
            switch($blog['Blog']['syntax']):
                case 'markdown':
                    //Parse the markdown to HTML
                    //Make sure clever hackers haven't found a way to turn clean markdown into evil HTML
                    echo Scrub::htmlMedia(Utility::markdown($blog['Blog']['body'])); 
                break;

                default:
                    echo $blog['Blog']['body']; 
                break;        
            endswitch;
            ?>
        </div>

        <div id="ResultsPage">
            <?php foreach($blog['Post'] as $post): ?>
            <div class="result">
                <h2><?php echo $this->Html->link($post['title'], $post['url']); ?></h2>
                <div class="tease">
                    <div class="meta meta-right"><?php echo Handy::date($post['created']); ?></div>
                    <?php echo $this->Text->truncate(
                            $post['body'], 
                            750, 
                            array(
                                'ending' => ' ' . $this->Html->link('(More...)', $post['url']),
                                'exact' => false,
                                'html' => true)); 
                    ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="one-third column omega"></div>
</div>

