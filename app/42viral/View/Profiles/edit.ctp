<h1>Complete Your Profile</h1>

<?php

echo $this->Form->create('Profile', array(
    'action' => 'save'
));

echo $this->Form->hidden('id');
echo $this->Form->input('bio');
echo $this->Form->input('first_name');
echo $this->Form->input('last_name');

echo $this->Form->submit('Submit');

echo $this->Form->end();

?>