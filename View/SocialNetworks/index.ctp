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

        <div id="ResultsPage">
            <?php if(empty($socialNetworks)): ?>
                <div class="no-results">
                    <div class="no-results-message">
                        <?php echo __("I'm sorry, there are no results to display."); ?>
                    </div>
                </div>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th><?php echo $this->Paginator->sort('network');?></th>
                        <th><?php echo $this->Paginator->sort('created');?></th>
                        <th><?php echo $this->Paginator->sort('modified');?></th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($socialNetworks as $socialNetwork): ?>
                        <tr>
                            <td><?php echo $socialNetwork['SocialNetwork']['profile_url']; ?></td>
                            <td><?php echo $socialNetwork['SocialNetwork']['network']; ?></td>
                            <td><?php echo $socialNetwork['SocialNetwork']['created']; ?></td>
                            <td><?php echo $socialNetwork['SocialNetwork']['modified']; ?></td>
                            <td class="actions">
                                <?php echo !$mine?null:$this->Html->link(__('Edit'),
                                        "/social_networks/edit/{$socialNetwork['SocialNetwork']['id']}"); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
            <?php echo $this->element('paginate'); ?>
        </div>
    </div>
    <div class="one-third column omega">
        <?php echo $this->element(
                'Blocks' . DS . 'aside',
                array(
                    'elements'=>array(
                        ## Sample pass an element with no arguments
                        ## 'Blocks' . DS . 'tag_cloud',
                        ## OR Pass an element with arguments
                        ## array('Navigation' . DS . 'menus', array('section'=>'social_network'))
                        array('Navigation' . DS . 'menus', array('section'=>'social_network'))
                    )
                )
            );
        ?>
    </div>
</div>