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

    if($mine):

        $additional  = array(
            array(
                'text'=>"Edit",
                'url'=>"/contents/blog_edit/{$blog['Blog']['id']}",
                'options' => array(),
                'confirm'=>null
            ),
            array(
                'text'=>"Delete",
                'url'=>"/contents/blog_delete/{$blog['Blog']['id']}",
                'options' => array(),
                'confirm'=>'Are you sure you want to delete this? \n This action CANNOT be reversed!'
            ),
        );

    else:
         $additional  = array();
    endif; 

    echo $this->element('Navigation' . DS . 'local', array('section'=>'blog'));

?>

<div style="margin: 3px 0;"><?php echo $blog['Blog']['tease']; ?></div>

<div id="ResultsPage">
    <?php foreach($blog['Post'] as $post): ?>
    <div class="result">
        <h2><?php echo $this->Html->link($post['title'], $post['url']); ?></h2>
        <div class="tease">
        <?php 
            echo $post['tease']; 
        ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

