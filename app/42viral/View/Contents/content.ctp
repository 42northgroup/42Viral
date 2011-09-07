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

<?php //debug($person); ?>

<h1><?php echo $this->Member->displayName($userProfile['Person']) ?>'s Content Stream</h1>
<?php echo $this->element('Blocks' . DS . 'Sub' . DS . 'profileNavigation'); ?>

<table>
    <thead>
        <tr>
            <th>Actions</th>
            <th>Type</th>
            <th>Title</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($userProfile['Content'] as $content):?>
        <tr>
            <td>
                <?php echo $this->Html->link('[E]', $content['edit_url']); ?>/
                <?php echo $this->Html->link('[D]', $content['delete_url']); ?>
            </td>
            <td>
               <?php echo Inflector::humanize($content['object_type']); ?> 
            </td>
            <td>
               <?php echo $this->Html->link($content['title'], $content['url']); ?> 
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

