<h1>Edit your blog post</h1>

<?php

    echo $this->Form->create('Post', 
                array(
                    'url'=>$this->here, 
                    'class'=>'content'
                )
            );
    echo $this->Form->input('id');
    echo $this->Form->input('title', array('rows'=>1, 'cols'=>96));
    echo $this->Form->input('canonical', array('rows'=>2, 'cols'=>96));
    echo $this->Form->input('body', array('class'=>'edit-basic'));
    echo $this->Form->input('tease', array('class'=>'edit-basic'));
    echo $this->Form->input('description', array('rows'=>6, 'cols'=>96));
    echo $this->Form->input('keywords', array('rows'=>6, 'cols'=>96));
    echo $this->Form->input('custom_file', array('empty'=>true));   
    echo $this->Form->input('canonical', array('rows'=>2, 'cols'=>96));
    echo $this->Form->input('slug', array('rows'=>2, 'cols'=>96));
    echo $this->Form->input('status');
    echo $this->Form->submit();
    echo $this->Form->end();

?>