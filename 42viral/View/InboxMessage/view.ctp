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