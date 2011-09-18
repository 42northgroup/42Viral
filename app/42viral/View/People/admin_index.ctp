<h1>People</h1>

<table>
    <thead>
        <th>Actions</th>
        <th>Name</th>
        <th>Username</th>
        <th>Email</th>
    </thead>
    <tbody>
        <?php foreach ($people as $person): ?>
        <tr>
            <td><?php echo $this->Html->link('View', $person['Person']['admin_url']); ?></td>            
            <td><?php echo $person['Person']['name']; ?></td>
            <td><?php echo $person['Person']['username']; ?></td>
            <td><?php echo $person['Person']['email']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>