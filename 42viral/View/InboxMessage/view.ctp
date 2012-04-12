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
    <div class="sixteen columns alpha omega">
        <div>
            Message:
            <?php
                echo $this->Html->link(
                    'Archive',
                    '/inbox_message/archive/' . $inbox_message['InboxMessage']['id']
                );
            ?>
            |
            <?php
                echo $this->Html->link(
                    'Delete',
                    '/inbox_message/delete/' . $inbox_message['InboxMessage']['id'],
                        
                    array(
                        'class' => 'delete-confirm'
                    )
                );
            ?>
        </div>

        <div class="result" style="margin-top: 20px;">
            <h3><?php echo $inbox_message['InboxMessage']['subject']; ?></h3>

            <p>
                <?php echo nl2br($inbox_message['InboxMessage']['body']); ?>
            </p>
        </div>
    </div>
</div>