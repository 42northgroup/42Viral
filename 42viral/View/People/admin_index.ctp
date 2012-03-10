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
        <th></th>
        <th>Name</th>
        <th>Username</th>
        <th>Email</th>
    </thead>
    <tbody>
        <?php foreach ($people as $person): ?>
        <tr>   
            <td class="actions-column"> 
                <div class="actions-control" style="position: relative;">
                    &#9658;
                    <div class="actions">
                        <?php echo $this->Html->link('View', $person['Person']['admin_url']); ?>
                        |
                        <a href="#">Edit</a>
                        |
                        <?php echo $this->Html->link('New Case', 
                                "/admin/people/create_case/{$person['Person']['username']}"); ?>
                        |
                        <a href="#">Delete</a>
                    </div> 
                </div>
            </td>
            <td><?php echo $person['Person']['name']; ?></td>
            <td><?php echo $person['Person']['username']; ?></td>
            <td><?php echo $person['Person']['email']; ?></td>
        </tr>     
        <?php endforeach; ?>
    </tbody>
</table>