<?php 

    $additional = array(
        array(
            'text'=>"Create a case",
            'url'=>"/admin/people/create_case/{$person['Person']['username']}",
            'options' => array(),
            'confirm'=>null
        )
    );

    echo $this->element('Navigation' . DS . 'local', array('section'=>'people', 'additional'=>$additional));     
?>

<h2>Cases</h2>
<?php if(!empty($person['Case'])): ?>
<table>
    <thead>
        <tr>
            <th>Case No.</th>
            <th>Subject</th>
            <th>Created</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($person['Case'] as $case): App::uses('Handy', 'Lib'); ?>
        <tr>
            <td><?php echo $this->Html->link($case['case_number'], $case['url']); ?></td>
            <td><?php echo $case['subject']; ?></td>
            <td><?php echo Handy::date($case['created']); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>  
<?php else:
    __('There are no cases to display!');
endif; ?>

