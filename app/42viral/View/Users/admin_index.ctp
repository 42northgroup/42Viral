<?php echo $this->element('Navigation' . DS . 'local', array('section'=>'')); ?>

<table>
    <thead>
        <th>Actions</th>
        <th>Name</th>
        <th>Handle</th>
        <th>Email</th>
    </thead>
    <tbody>
        <?php foreach ($people as $person): ?>
        <tr>
            <td>
                <?php echo $this->Access->link( 
                        'Privileges-admin_user_privileges', 
                        'Privs', 
                        "/admin/privileges/user_privileges/{$person['Person']['username']}"); ?>
            </td>            
            <td><?php echo $person['Person']['name']; ?></td>
            <td><?php echo $person['Person']['username']; ?></td>
            <td><?php echo $person['Person']['email']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>