<h1>People</h1>

<table>
    <thead>
        <th colspan="2">Name</th>
        <th>Handle</th>
        <th>Email</th>
        <th>Actions</th>
    </thead>
    <tbody>
        <?php foreach ($people as $person): ?>
        <tr>
            <td><?php echo $person['Person']['first_name']; ?></td>
            <td><?php echo $person['Person']['last_name']; ?></td>
            <td><?php echo $person['Person']['username']; ?></td>
            <td><?php echo $person['Person']['email']; ?></td>
            <td>
                [Edit Profile] 
                <a href="/admin/privileges/user_privileges/<?php echo $person['Person']['username']; ?>">
                    [Edit Privileges]
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h1>Groups</h1>

<a href="/admin/users/create_group" >Create New Group</a>
<?php if(!empty ($acl_groups)): ?>
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
        <?php foreach ($acl_groups as $acl_group): ?>

            <tr>
                <td><?php echo $acl_group['AclGroup']['alias']; ?></td>            
                <td>        
                    <a href="/admin/privileges/user_privileges/<?php echo $acl_group['AclGroup']['alias']; ?>">
                        [Edit Privileges]
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>            
        </tbody>
    </table>    
<?php endif; ?>