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

<h2>Picklist - View</h2>

<table>
    <tbody>
        <tr>
            <td>
                Alias
            </td>
            
            <td>
                <?php echo $picklist['Picklist']['alias']; ?>
            </td>
        </tr>
        
        <tr>
            <td>
                Name
            </td>

            <td>
                <?php echo $picklist['Picklist']['name']; ?>
            </td>
        </tr>

        <tr>
            <td>
                Description
            </td>

            <td>
                <?php echo $picklist['Picklist']['description']; ?>
            </td>
        </tr>
        
        <tr>
            <td>
                Active
            </td>

            <td>
                <?php echo ($picklist['Picklist']['active'])? 'Yes': 'No'; ?>
            </td>
        </tr>
    </tbody>
</table>

<div>
    <h2 style="display: inline-block;">Picklist Options</h2>
    <a href="/admin/picklist_manager/picklists/add_option/<?php echo $picklist['Picklist']['id']; ?>"
       title="Add new picklist option to this picklist">Add picklist option</a>
</div>

<div style="border: 1px solid #aaa; padding: 10px;">
    <?php if(!empty($picklist['PicklistOption'])): ?>

            <table>
                <thead>
                    <tr>
                        <td>Category</td>
                        <td>Group</td>
                        
                        <td>List Key</td>
                        <td>List Value</td>
                        
                        <td>Active</td>
                        <td>Actions</td>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($picklist['PicklistOption'] as $tempPicklistOption): ?>
                        <tr>
                            <td><?php echo $tempPicklistOption['category']; ?></td>

                            <td><?php echo $tempPicklistOption['group']; ?></td>

                            <td>
                                <a href="/admin/picklist_manager/picklists/edit_option/<?php echo $tempPicklistOption['id']; ?>"
                                   title="Edit picklist option">
                                   <?php echo $tempPicklistOption['pl_key']; ?>
                                </a>
                            </td>

                            <td><?php echo $tempPicklistOption['pl_value']; ?></td>

                            <td><?php echo ($tempPicklistOption['active'])? 'Yes': 'No'; ?></td>

                            <td>
                                <a href="/admin/picklist_manager/picklists/edit_option/<?php
                                    echo $tempPicklistOption['id']; ?>"
                                   title="Edit picklist option">Edit</a>
                                /
                                <a href="/admin/picklist_manager/picklists/delete_option/<?php
                                    echo $tempPicklistOption['id']; ?>"
                                   title="Delete picklist option"
                                   class="delete-confirm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

    <?php else: ?>
        <div style="text-align: center;">
            <h3>No picklist options created</h3>
            <a href="/admin/picklist_manager/picklists/add_option/<?php echo $picklist['Picklist']['id']; ?>"
               title="Add new picklist option to this picklist">Add picklist option</a>
        </div>
    <?php endif; ?>

    <?php //debug($picklist); ?>
</div>