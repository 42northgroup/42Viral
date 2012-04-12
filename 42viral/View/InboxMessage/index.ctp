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
<style type="text/css">
    .read-message {
        font-weight: normal;
    }

    .unread-message {
        font-weight: bold;
        background-color: #ddd;
    }
</style>

<h1><?php echo $title_for_layout; ?></h1>
<div class="row">
    <div class="sixteen columns alpha omega">
        <div>
            Archived messages:
            <?php
                echo $this->Html->link(
                    'Show',
                    '/inbox_message/index/show_archived:1'
                );
            ?>
            |
            <?php
                echo $this->Html->link(
                    'Hide',
                    '/inbox_message/index'
                );
            ?>
        </div>
        
        <?php if(!empty($messages)): ?>
            <div>
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>Subject</th>
                            <th>Date/Time</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $itemCounter = 1; ?>

                        <?php foreach($messages as $message): ?>
                            <tr class="<?php echo ($message['InboxMessage']['read'])? 'read-message': 'unread-message'; ?>">
                                <td>
                                    <a href="/inbox_message/view/<?php echo $message['InboxMessage']['id']; ?>"><?php
                                        echo $itemCounter++;
                                    ?></a>
                                </td>

                                <td>
                                    <a href="/inbox_message/view/<?php echo $message['InboxMessage']['id']; ?>"><?php
                                        echo $message['InboxMessage']['subject'];
                                    ?></a>
                                </td>

                                <td>
                                    <?php echo date('m/d/Y H:i:s', strtotime($message['InboxMessage']['created'])); ?>
                                </td>
                            </tr>


                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php else: ?>

            <?php echo $this->element('no_results', array('message'=>__('No new messages'))); ?>

        <?php endif; ?>
    </div>
</div>
