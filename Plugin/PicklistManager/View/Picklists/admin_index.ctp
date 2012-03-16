<?php
/**
 * Copyright 2012, Zubin Khavarian (http://zubink.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, Zubin Khavarian (http://zubink.com)
 * @link http://zubink.com
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

<?php echo $this->element('navigation'); ?>

<h2>Picklist - Index</h2>

<?php if(!empty($picklists)): ?>

    <table>
        <thead>
            <tr>
                <td>Name</td>
                <td>Alias</td>
                <td>Active</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($picklists as $tempPicklist): ?>
                <tr class="top">
                    <td>
                        <a href="/admin/picklist_manager/picklists/view/<?php echo $tempPicklist['Picklist']['id']; ?>"
                           title="View picklist">
                            <?php echo $tempPicklist['Picklist']['name']; ?>
                        </a>
                    </td>
                    
                    <td>
                        <?php echo $tempPicklist['Picklist']['alias']; ?>
                    </td>

                    <td>
                        <?php echo ($tempPicklist['Picklist']['active'])? 'Yes': 'No'; ?>
                    </td>
                </tr>
                <tr class="bottom">
                    <td colspan="3">
                        <a href="/admin/picklist_manager/picklists/delete/<?php echo $tempPicklist['Picklist']['id']; ?>"
                           title="Delete picklist"
                           class="delete-confirm">Delete</a>
                        /
                        <a href="/admin/picklist_manager/picklists/edit/<?php echo $tempPicklist['Picklist']['id']; ?>"
                           title="Edit picklist">Edit</a>
                        /
                        <a href="/admin/picklist_manager/picklists/test/<?php echo $tempPicklist['Picklist']['id']; ?>"
                           title="Test picklist HTML in grouped and flat versions">Test</a>
                        
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>

    <h3>No picklists created 
    <a href="/admin/picklist_manager/picklists/create"
       title="Create a new picklist">Create one</a></h3>

<?php endif; ?>
