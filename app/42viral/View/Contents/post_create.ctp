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
 * @package app
 * @package app.core
 **** @author Jason D Snider <jason.snider@42viral.org>
 */
?>

<?php if(isset($this->params['pass'][0])): ?>

    <h1>Post to the blog</h1>
    
    <?php

        echo $this->Form->create('Post', 
                    array(
                        'url'=>$this->here, 
                        'class'=>'content'
                    )
                );
        echo $this->Form->input('parent_content_id', array('value'=>$this->params['pass'][0], 'type'=>'hidden'));
        echo $this->Form->input('title', array('rows'=>1, 'cols'=>96));
        echo $this->Form->submit();
        echo $this->Form->end();

    ?>
    
<?php else: ?>

    <h1>Choose the blog you would like to post to</h1>
    <table>
        <tbody>
        <?php foreach($blogs as $blog): ?>
            <tr>
                <td>
                    <?php echo $this->Html->link(
                            $blog['Blog']['title'], "/contents/post_create/{$blog['Blog']['id']}"); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>
