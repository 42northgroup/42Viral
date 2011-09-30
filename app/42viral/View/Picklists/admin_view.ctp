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

<h1>Picklist - View</h1>

<div class="">
    <a href="/admin/picklists/index"
       title="Index of all picklists">Index</a>
    /
    <a href="/admin/picklists/edit/<?php echo $picklist['Picklist']['id']; ?>"
       title="Edit picklist">Edit</a>
    /
    <a href="/admin/picklists/delete/<?php echo $picklist['Picklist']['id']; ?>"
       title="Delete picklist"
       class="delete-confirm">Delete</a>
    /
    <a href="/admin/picklists/test/<?php echo $picklist['Picklist']['id']; ?>"
       title="Test picklist">Test</a>
</div>

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
    <a href="/admin/picklists/add_option/<?php echo $picklist['Picklist']['id']; ?>"
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
                                <a href="/admin/picklists/edit_option/<?php echo $tempPicklistOption['id']; ?>"
                                   title="Edit picklist option">
                                   <?php echo $tempPicklistOption['pl_key']; ?>
                                </a>
                            </td>

                            <td><?php echo $tempPicklistOption['pl_value']; ?></td>

                            <td><?php echo ($tempPicklistOption['active'])? 'Yes': 'No'; ?></td>

                            <td>
                                <a href="/admin/picklists/edit_option/<?php echo $tempPicklistOption['id']; ?>"
                                   title="Edit picklist option">Edit</a>
                                /
                                <a href="/admin/picklists/delete_option/<?php echo $tempPicklistOption['id']; ?>"
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
            <a href="/admin/picklists/add_option/<?php echo $picklist['Picklist']['id']; ?>"
               title="Add new picklist option to this picklist">Add picklist option</a>
        </div>
    <?php endif; ?>

    <?php //debug($picklist); ?>
</div>