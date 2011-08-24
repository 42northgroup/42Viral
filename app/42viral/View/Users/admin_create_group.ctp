<h1>Create a Group</h1>
<?php

    echo $this->Form->create('AclGroup', 
                array(
                    'url'=>$this->here, 
                    'class'=>'default'
                )
            );
    
    echo $this->Form->input('alias');
    
    echo $this->Form->submit();
    echo $this->Form->end();

?>
