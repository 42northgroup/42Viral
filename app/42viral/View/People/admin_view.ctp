<h1><?php echo $person['Person']['name']; ?></h1>
<?php echo $this->Html->link('Create a case', "/admin/people/create_case/{$person['Person']['username']}"); ?>

<table>
<?php if(!empty($person['Case'])): ?>
    <?php foreach($person['Case'] as $case): ?>
        <tr><td><?php echo $case['subject']; ?></td></tr>
    <?php endforeach; ?>
<?php endif; ?>
</table>
