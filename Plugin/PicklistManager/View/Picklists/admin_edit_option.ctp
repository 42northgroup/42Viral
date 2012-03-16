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

<h2>Picklist - Edit Picklist Option</h2>

<?php
echo $this->Form->create('PicklistOption', array(
    'url' => "/admin/picklist_manager/picklists/edit_option/{$picklist_option_id}",
    'class' => 'content'
));

echo $this->Form->input('id'); 

echo $this->Form->input('pl_key', array(
    'label' => 'Picklist Option Key'
));

echo $this->Form->input('pl_value', array(
    'label' => 'Picklist Option Value'
));

echo $this->Form->input('category');

echo $this->Form->input('group');

echo $this->Form->input('active', array(
    'checked' => true
));

echo $this->Form->submit('Update');
echo $this->Form->end();