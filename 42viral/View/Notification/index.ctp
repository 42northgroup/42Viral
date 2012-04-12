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

<?php echo $this->element('Navigation' . DS . 'local', array('section' => 'notifications')); ?>

<?php if(!empty($notifications)): ?>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Alias</th>
                <th>Active</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($notifications as $tempNotification): ?>
                <tr class="top">
                    <td>
                        <a href="/notification/view/<?php echo $tempNotification['Notification']['id']; ?>">
                            <?php echo $tempNotification['Notification']['name']; ?>
                        </a>
                    </td>

                    <td>
                        <?php echo $tempNotification['Notification']['alias']; ?>
                    </td>

                    <td>
                        <?php echo ($tempNotification['Notification']['active'])? 'Y': 'N'; ?>
                    </td>
                </tr>
                
                <tr class="bottom">
                    <td colspan="3">
                        <a href="/notification/edit/<?php echo $tempNotification['Notification']['id']; ?>">Edit</a>
                        /
                        <a href="/notification/delete/<?php echo $tempNotification['Notification']['id']; ?>"
                           class="delete-confirm">Delete</a>
                        /
                        <a href="/notification/test/<?php echo $tempNotification['Notification']['id']; ?>"
                           >Test Fire</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>

    <h3>No notifications to display</h3>

<?php endif; ?>