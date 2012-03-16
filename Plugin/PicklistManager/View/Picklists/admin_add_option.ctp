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

<h2>Picklist - Add Picklist Option</h2>

<?php
echo $this->Form->create('PicklistOption', array(
    'url' => $this->here,
    'class' => 'content'
));

echo $this->Form->input('picklist_id', array(
    'type' => 'hidden',
    'value' => $picklist_id
));

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

echo $this->Form->submit('Add');
echo $this->Form->end();

?>