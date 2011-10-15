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
 * Picklist UI
 *** @author Zubin Khavarian <zubin.khavarian@42viral.org>
 */

echo $this->element('Navigation' . DS . 'local', array('section'=>'picklists'));
?>


<?php

echo $this->Form->create('Picklist', array(
    'url' => $this->here,
    'class' => 'content'
));

echo $this->Form->input('id');

echo $this->Form->input('alias');

echo $this->Form->input('name');

echo $this->Form->input('description', array(
    'type' => 'textarea'
));

echo $this->Form->input('active', array(
    'checked' => true
));

echo $this->Form->submit('Update');
echo $this->Form->end();

?>