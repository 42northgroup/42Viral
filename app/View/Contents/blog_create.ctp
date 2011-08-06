<h1>Create a blog</h1>
<?php

    echo $this->Form->create('Blog', 
                array(
                    'url'=>$this->here, 
                    'class'=>'content'
                )
            );
    
    echo $this->Form->input('title', array('rows'=>1, 'cols'=>85));
    echo $this->Form->submit();
    echo $this->Form->end();

?>
