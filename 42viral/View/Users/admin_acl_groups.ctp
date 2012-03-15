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

echo $this->element('Navigation' . DS . 'local', array('section'=>'acl_groups'));

?>
<?php if(!empty ($aclGroups)): ?>
    <table>
        <thead>
            <th>
                Group
            </th>
        </thead>
        <tbody>
        <?php foreach ($aclGroups as $aclGroup): ?>

            <tr class="top">
                <td><?php echo $aclGroup['AclGroup']['alias']; ?></td>            
            </tr>
            <tr class="bottom">
                <td>     
                    <?php echo $this->Html->link(
                            'User Group Privileges',
                            "/admin/privileges/user_privileges/{$aclGroup['AclGroup']['alias']}"); ?>
                </td>           
            </tr>
        <?php endforeach; ?>            
        </tbody>
    </table>    
<?php endif; ?>