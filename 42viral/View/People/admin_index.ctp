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

echo $this->element('Navigation' . DS . 'local', array('section'=>'admin_people')); 

?>
<table>
    <thead>
        <th>Name</th>
        <th>Username</th>
        <th>Email</th>
    </thead>
    <tbody>
        <?php foreach ($people as $person): ?>
        <tr class="top">   
            <td>
                <?php echo empty($person['Person']['name']) 
                    ? '<span class="empty">[Not Set]</span>'
                    : $person['Person']['name']; ?>
            </td>
            <td><?php echo $person['Person']['username']; ?></td>
            <td><?php echo $person['Person']['email']; ?></td>
        </tr>     
        <tr class="bottom">
            <td colspan="3">
                <?php echo $this->Html->link('View', $person['Person']['admin_url']); ?>
                |
                <a href="#">Edit</a>
                |
                <a href="#">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>