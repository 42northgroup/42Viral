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
 * @author Jason D Snider <jsnider77@gmail.com>
 */
?>

<h1>Look at all the content you've created</h1>

<table>
    <thead>
        <tr>
            <th>Actions</th>
            <th>Type</th>
            <th>Title</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($contents as $content):?>
        <tr>
            <td>
                <?php echo $this->Html->link('[E]', $content['Content']['edit_url']); ?>/
                <?php echo $this->Html->link('[D]', $content['Content']['delete_url']); ?>
            </td>
            <td>
               <?php echo Inflector::humanize($content['Content']['object_type']); ?> 
            </td>
            <td>
               <?php echo $this->Html->link($content['Content']['title'], $content['Content']['url']); ?> 
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

