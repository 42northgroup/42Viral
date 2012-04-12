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
        <?php if(isset($this->params['pass'][0])): ?>

            <?php

                echo $this->Form->create('Post', 
                            array(
                                'url'=>$this->here, 
                                'class'=>'responsive'
                            )
                        );
                
                echo $this->Form->input('parent_content_id', 
                        array('value'=>$this->params['pass'][0], 'type'=>'hidden'));
                
                echo $this->Form->input('title');
                
                echo $this->Form->submit();
                
                echo $this->Form->end();

            ?>

        <?php else: ?>

            <?php if(empty($blogs)): ?> 
                <h2>
                    <?php echo "You don't have any blogs to post to " 
                        . $this->Html->link('Create One', '/blogs/create/') . " now."; ?>
                </h2>
            <?php else: ?>
        
                <h2><?php echo __('Choose the blog to which you would like to post.'); ?></h2>

                <table>
                    <tbody>
                    <?php foreach($blogs as $blog):?>
                        <tr>
                            <td>
                                <?php echo $this->Html->link(
                                        $blog['Blog']['title'], 
                                        "/posts/create/{$blog['Blog']['id']}"); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
            </table>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="one-third column omega"></div>
</div>
