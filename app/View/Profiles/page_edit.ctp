<h1>Create a page</h1>
<?php

    echo $this->Form->create('Page', 
                array(
                    'url'=>$this->here, 
                    'class'=>'content'
                )
            );
    echo $this->Form->input('id');
    echo $this->Form->input('title', array('rows'=>1, 'cols'=>85));
    echo $this->Form->input('canonical', array('rows'=>2, 'cols'=>85));
    echo $this->Form->input('body', array('rows'=>20, 'cols'=>85));
    echo $this->Form->input('tease', array('rows'=>6, 'cols'=>85));
    echo $this->Form->input('description', array('rows'=>6, 'cols'=>85));
    echo $this->Form->input('keywords', array('rows'=>6, 'cols'=>85));
    echo $this->Form->submit();
    echo $this->Form->end();

?>
