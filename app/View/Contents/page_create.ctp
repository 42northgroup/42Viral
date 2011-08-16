<h1>Create a page</h1>
<?php

    echo $this->Form->create('Page', 
                array(
                    'url'=>$this->here, 
                    'class'=>'content'
                )
            );
    
    echo $this->Form->input('title', array('rows'=>1, 'cols'=>62));
    echo $this->Form->submit();
    echo $this->Form->end();

?>
