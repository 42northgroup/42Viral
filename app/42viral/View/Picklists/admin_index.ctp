<?php
/**
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

<?php
    //debug($picklists);
?>

<h1>Picklist - Index</h1>

<div class="">
    <a href="/admin/picklists/create"
       title="Create a new picklist">Create</a>
</div>

<?php if(!empty($picklists)): ?>

    <table>
        <thead>
            <tr>
                <td>Name</td>
                <td>Alias</td>
                <td>Actions</td>
                <td>Active</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($picklists as $tempPicklist): ?>
                <tr>
                    <td>
                        <a href="/admin/picklists/view/<?php echo $tempPicklist['Picklist']['id']; ?>"
                           title="View picklist">
                            <?php echo $tempPicklist['Picklist']['name']; ?>
                        </a>
                    </td>
                    
                    <td>
                        <?php echo $tempPicklist['Picklist']['alias']; ?>
                    </td>

                    <td>
                        <a href="/admin/picklists/delete/<?php echo $tempPicklist['Picklist']['id']; ?>"
                           title="Delete picklist"
                           class="delete-confirm">Delete</a>
                        /
                        <a href="/admin/picklists/edit/<?php echo $tempPicklist['Picklist']['id']; ?>"
                           title="Edit picklist">Edit</a>
                        /
                        <a href="/admin/picklists/test/<?php echo $tempPicklist['Picklist']['id']; ?>"
                           title="Test picklist HTML in grouped and flat versions">Test</a>
                        
                    </td>

                    <td>
                        <?php echo ($tempPicklist['Picklist']['active'])? 'Yes': 'No'; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>

    <h3>No picklists created 
    <a href="/admin/picklists/create"
       title="Create a new picklist">Create one</a></h3>

<?php endif; ?>
