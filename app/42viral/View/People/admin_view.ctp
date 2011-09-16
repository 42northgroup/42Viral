<h1><?php echo $person['Person']['name']; ?></h1>
<?php echo $this->Html->link('Create a case', "/admin/people/create_case/{$person['Person']['username']}"); ?>


<h2>Cases</h2>
<?php if(!empty($person['Case'])): ?>
<table>
    <thead>
        <tr>
            <th>Created</th>
            <th>Subject</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($person['Case'] as $case): App::uses('Handy', 'Lib'); ?>
        <tr>
            <td><?php echo Handy::date($case['created']); ?></td>
            <td><?php echo $case['subject']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>  
<?php else:
    __('There are no cases to display!');
endif; ?>

