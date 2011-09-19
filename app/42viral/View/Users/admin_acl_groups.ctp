<h1>ACL Groups</h1>

<a href="/admin/users/create_acl_group" >Create New Group</a>
<?php if(!empty ($aclGroups)): ?>
    <table>
        <thead>
            <th>
                Group
            </th>
            <th>
                Actions
            </th>
        </thead>
        <tbody>
        <?php foreach ($aclGroups as $aclGroup): ?>

            <tr>
                <td>     
                    <?php echo $this->Access->link('Privileges-admin_user_privileges', 
                            'User Group Privileges',
                            "/admin/privileges/user_privileges/{$aclGroup['AclGroup']['alias']}"); ?>
                </td>
                <td><?php echo $aclGroup['AclGroup']['alias']; ?></td>            
            </tr>

        <?php endforeach; ?>            
        </tbody>
    </table>    
<?php endif; ?>