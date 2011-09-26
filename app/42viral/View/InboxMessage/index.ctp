<style type="text/css">
    .read-message {
        font-weight: normal;
    }

    .unread-message {
        font-weight: bold;
        background-color: #ddd;
    }
</style>

<h1>Unread Notification Count: <?php echo $unread_count; ?></h1>

<?php
    //debug($all_messages);
?>


<?php if(!empty($all_messages)): ?>

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

<?php else: ?>

    <h3>No messages to display</h3>
    
<?php endif; ?>
