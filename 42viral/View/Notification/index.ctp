<?php echo $this->element('Navigation' . DS . 'local', array('section'=>'notifications')); ?>

<?php if(!empty($notifications)): ?>

    <table>
        <thead>
            <tr>
                <td></td>
                <td>Name</td>
                <td>Alias</td>
                <td>Actions</td>
                <td>Active</td>
            </tr>
        </thead>

        <tbody>
            <?php foreach($notifications as $tempNotification): ?>
                <tr>
                    <td>

                    </td>

                    <td>
                        <a href="/notification/view/<?php echo $tempNotification['Notification']['id']; ?>">
                            <?php echo $tempNotification['Notification']['name']; ?>
                        </a>
                    </td>

                    <td>
                        <?php echo $tempNotification['Notification']['alias']; ?>
                    </td>

                    <td>
                        <a href="/notification/edit/<?php echo $tempNotification['Notification']['id']; ?>">Edit</a>
                        /
                        <a href="/notification/delete/<?php echo $tempNotification['Notification']['id']; ?>"
                           class="delete-confirm">Delete</a>
                        /
                        <a href="/notification/test/<?php echo $tempNotification['Notification']['id']; ?>"
                           >Test Fire</a>
                    </td>

                    <td>
                        <?php echo ($tempNotification['Notification']['active'])? 'Y': 'N'; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>

    <h3>No notifications to display</h3>

<?php endif; ?>