<style type="text/css">
    .read-message {
        font-weight: normal;
    }

    .unread-message {
        font-weight: bold;
        background-color: #ddd;
    }

    .inbox-message {
        border: 1px solid #aaa;
        padding: 10px;
        margin: 10px;
    }
</style>

<?php
    //debug($all_messages);
?>


<?php if(!empty($all_messages)): ?>
    <div class="inbox-message">
        <table>
            <tbody>
                <?php foreach($all_messages as $message): ?>
                    <tr class="<?php echo ($message['InboxMessage']['read'])? 'read-message': 'unread-message'; ?>">
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

    <h3>No messages to display</h3>
    
<?php endif; ?>
