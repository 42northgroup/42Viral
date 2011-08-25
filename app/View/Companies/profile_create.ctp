<h1>Create Company Profile</h1>

<?php

echo $this->Form->create('Company', array(
    'action' => 'profile_save'
));

echo $this->Form->input('Company.name');
echo $this->Form->input('Company.addr_line1');
echo $this->Form->input('Company.addr_line2');
echo $this->Form->input('Company.addr_city');
echo $this->Form->input('Company.addr_state');
echo $this->Form->input('Company.addr_zip');

echo $this->Form->submit('Save');
echo $this->Form->end();
