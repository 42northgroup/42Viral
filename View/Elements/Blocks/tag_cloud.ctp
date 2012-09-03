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
<div class="column-block">
    <div class="navigation-block">
        <?php
            echo $this->Html->tag('h4', __('Tag Cloud'));
            echo $this->TagCloud->display($tags, array(
                'before' => '<span style="font-size:%size%%" class="tag">',
                'after' => '</span>',
                'url'=>array(
                    'controller' => 'searches',
                    'action' => '/tags/',
                    ),
                'named'=>'q'
                )
            );
        ?>
    </div>
</div>
