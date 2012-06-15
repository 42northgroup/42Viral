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
                    <th><?php echo $this->Paginator->sort('type');?></th>
                    <th><?php echo $this->Paginator->sort('label');?></th>
                    <th><?php echo $this->Paginator->sort('value');?></th>
                    <th class="actions"><?php echo __d('tags', 'Actions');?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($contactDetails as $contactDetail): ?>
                <tr>
                    <td><?php echo $contactDetail['ContactDetail']['type']; ?></td>
                    <td><?php echo $contactDetail['ContactDetail']['label']; ?></td>
                    <td><?php echo $contactDetail['ContactDetail']['value']; ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('Edit'),
                                "/contact_details/edit/{$contactDetail['ContactDetail']['id']}"); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php echo $this->element('paginate'); ?>
    </div>
    <div class="one-third column omega">
        <?php echo $this->element('Navigation' . DS . 'menus', array('section'=>'contact_detail')); ?>
    </div>
</div>
