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
                    <th><?php echo $this->Paginator->sort('profile');?></th>
                    <th><?php echo $this->Paginator->sort('network');?></th>
                    <th><?php echo $this->Paginator->sort('created');?></th>
                    <th><?php echo $this->Paginator->sort('modified');?></th>
                    <th class="actions"><?php echo __d('tags', 'Actions');?></th>
                </tr>
            </thead>
            <tbody>
            <?php if(!empty($socialNetworks)): ?>
                <?php foreach ($socialNetworks as $socialNetwork): ?>
                    <tr>
                        <td><?php echo $socialNetwork['SocialNetwork']['identifier']; ?></td>
                        <td><?php echo $socialNetwork['SocialNetwork']['network']; ?></td>
                        <td><?php echo $socialNetwork['SocialNetwork']['created']; ?></td>
                        <td><?php echo $socialNetwork['SocialNetwork']['modified']; ?></td>
                        <td class="actions">
                            <?php echo $this->Html->link(__('Edit'),
                                    "/social_networks/edit/{$socialNetwork['SocialNetwork']['id']}"); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5"><?php echo __('There are no social networks associated with this record'); ?></td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
        <?php echo $this->element('paginate'); ?>
    </div>
    <div class="one-third column omega">
        <?php echo $this->element('Navigation' . DS . 'menus', array('section'=>'social_network')); ?>
    </div>
</div>
