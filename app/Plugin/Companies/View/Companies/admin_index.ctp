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

/**
 * @author Jason D Snider <jason.snider@42viral.org>
 */

echo $this->element('Navigation' . DS . 'local', array('section'=>'admin_companies')); 

?>

<table>
    <thead>
        <th></th>
        <th>Name</th>
    </thead>
    <tbody>
        <?php foreach ($companies as $company): ?>
        <tr>  
            <td class="actions-column"> 
                <div class="actions-control" style="position: relative;">
                    &#9658;
                    <div class="actions">
                        <?php echo $this->Html->link('View', $company['Company']['admin_view_url']); ?>
                        |
                        <?php echo $this->Html->link('Edit', $company['Company']['admin_edit_url']); ?>
                        |
                        <?php echo $this->Html->link('Delete', $company['Company']['admin_delete_url']); ?>
                    </div>
                </div>
            </td>
            <td><?php echo $company['Company']['name']; ?></td>
        </tr> 
        <?php endforeach; ?>
    </tbody>
</table>