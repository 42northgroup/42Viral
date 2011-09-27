<<<<<<< HEAD

=======
>>>>>>> Applied the new navigation to multiple pages
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

    $additional = array(
        array(
            'text'=>"Create a Case",
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

