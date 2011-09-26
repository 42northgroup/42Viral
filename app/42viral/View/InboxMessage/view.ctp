<?php //debug($inbox_message); ?>

<style type="text/css">
    .inbox-message {
        border: 1px solid #aaa;
        padding: 10px;
        margin: 10px;
    }
</style>

<div class="inbox-message">
    <h3><?php echo $inbox_message['InboxMessage']['subject']; ?></h3>

    <p>
        <?php echo nl2br($inbox_message['InboxMessage']['body']); ?>
    </p>
</div>