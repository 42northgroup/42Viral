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
        <table>
            <thead>
                <tr>
                    <th><?php echo $this->Paginator->sort('label');?></th>
                    <th><?php echo $this->Paginator->sort('email_address');?></th>
                    <th class="actions"><?php echo __d('tags', 'Actions');?></th>
                </tr>
            </thead>
            <tbody>
            <?php if(!empty($emailAddresses)): ?>
                <?php foreach ($emailAddresses as $emailAddress): ?>
                <tr>
                    <td><?php echo $emailAddress['EmailAddress']['label']; ?></td>
                    <td><?php echo $emailAddress['EmailAddress']['email_address']; ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('Edit'),
                                "/email_addresses/edit/{$emailAddress['EmailAddress']['id']}"); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3"><?php echo __('There are no email addresses associated with this record'); ?></td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <?php echo $this->element('paginate'); ?>
    </div>
    <div class="one-third column omega">
        <?php echo $this->element('Navigation' . DS . 'menus', array('section'=>'email_address')); ?>
    </div>
</div>
