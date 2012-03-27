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

<h1><?php echo $title_for_layout; ?></h1>
<div class="row">
    <div class="sixteen columns alpha omega">
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

            <?php echo $this->element('no_results', array('message'=>__('No messages to display'))); ?>

        <?php endif; ?>
    </div>
</div>