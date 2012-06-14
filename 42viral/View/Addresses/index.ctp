<?php
/**
 * Copyright 2009-2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2009-2010, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<h1><?php echo $title_for_layout; ?></h1>

<div class="row">
    <div class="two-thirds column alpha">
        <table>
            <thead>
                <tr>
                    <th><?php echo $this->Paginator->sort('line1');?></th>
                    <th><?php echo $this->Paginator->sort('line2');?></th>
                    <th><?php echo $this->Paginator->sort('city');?></th>
                    <th><?php echo $this->Paginator->sort('zip');?></th>
                    <th><?php echo $this->Paginator->sort('state');?></th>
                    <th class="actions"><?php echo __d('tags', 'Actions');?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($addresses as $address): ?>
                <tr>
                    <td><?php echo $address['Address']['line1']; ?></td>
                    <td><?php echo $address['Address']['line2']; ?></td>
                    <td><?php echo $address['Address']['city']; ?></td>
                    <td><?php echo $address['Address']['state']; ?></td>
                    <td><?php echo $address['Address']['zip']; ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('Edit'),
                                "/addresses/edit/{$address['Address']['id']}"); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php echo $this->element('paginate'); ?>
    </div>
    <div class="one-third column omega">
        <?php echo $this->element('Navigation' . DS . 'menus', array('section'=>'address')); ?>
    </div>
</div>
