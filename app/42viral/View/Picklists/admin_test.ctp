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
?>

<?php
//debug($picklistGrouped);
//debug($picklistFlat);
?>

<h1>Picklist - Test</h1>

<div class="">
    <a href="/admin/picklists/index"
       title="Index of all picklists">Index</a>
</div>

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