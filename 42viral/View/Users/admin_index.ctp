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

<div class="row">
    <div class="sixteen columns alpha omega">
        <table>
            <thead>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr class="top"> 
                    <td><?php echo $user['User']['name']; ?></td>
                    <td><?php echo $user['User']['username']; ?></td>
                    <td><?php echo $user['User']['email']; ?></td>
                </tr>     
                <tr class="bottom">
                    <td colspan="3">
                        <?php echo $this->Html->link('View', $user['User']['admin_url']); ?>
                        |

                        <!--
                        <a href="#">Edit</a>
                        |
                        -->

                        <?php echo $this->Html->link(                        
                                'Privs', 
                                "/admin/privileges/user_privileges/{$user['User']['username']}"); ?>

                        <!--
                        |
                        <a href="#">Delete</a>
                        -->
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>