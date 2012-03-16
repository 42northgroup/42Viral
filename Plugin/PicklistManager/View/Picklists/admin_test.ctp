<?php
/**
 * Copyright 2012, Zubin Khavarian (http://zubink.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, Zubin Khavarian (http://zubink.com)
 * @link http://zubink.com
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

<?php echo $this->element('navigation'); ?>

<h2>Picklist - Test</h2>

<h3><u>Picklist Name</u>: <?php echo $picklist['Picklist']['name']; ?></h3>

<div style="display: inline-block; margin: 10px; padding: 30px; border: 1px solid #aaa;">
    <h1>Picklist Grouped</h1>
    <?php
    echo $this->Form->create();
    echo $this->Form->select('Picklist', $picklist_grouped, array(
        'empty' => false
    ));
    //echo $this->Form->submit();
    echo $this->Form->end();
    ?>
</div>

<div style="display: inline-block; margin: 10px; padding: 30px; border: 1px solid #aaa;">
    <h1>Picklist Flat</h1>
    <?php
    echo $this->Form->create();
    echo $this->Form->select('Picklist', $picklist_flat, array(
        'empty' => false
    ));
    //echo $this->Form->submit();
    echo $this->Form->end();
    ?>
</div>