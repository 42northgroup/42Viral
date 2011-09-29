<h1>Hellp Picklist Admin</h1>

<?php

debug($picklist);


echo $this->Form->create();
echo $this->Form->input('Picklist', array('options' => $picklist));
echo $this->Form->submit();
echo $this->Form->end();

?>