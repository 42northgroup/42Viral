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
 **** @author Jason D Snider <jason.snider@42viral.org>
 */
?>

<h1>Blogs</h1>

<div id="ResultsPage">
    <?php foreach($blogs as $blog): ?>
    <div class="result">
        <h2><?php echo $this->Html->link($blog['Blog']['title'], $blog['Blog']['url']); ?></h2>
        <div class="tease">
        <?php 
            echo $this->Text->truncate(
                    $blog['Blog']['tease'], 200, array('ending' => '...', 'exact' => true, 'html' => true)); 
        ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>