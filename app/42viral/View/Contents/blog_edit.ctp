<?php
    $this->Asset->addAssets(array(
        'js/vendors/ckeditor/adapters/42viral.js',
        'js/vendors/ckeditor/ckeditor.js',
        'js/vendors/ckeditor/adapters/jquery.js'
    ), 'ck_editor');

    echo $this->Asset->buildAssets('js', 'ck_editor', false);
?>

<h1>Edit your blog</h1>
<?php

    echo $this->Form->create('Blog', 
                array(
                    'url'=>$this->here, 
                    'class'=>'content'
                )
            );
    echo $this->Form->input('id');
    echo $this->Form->input('title', array('rows'=>1, 'cols'=>96));
    echo $this->Form->input('body', array('class'=>'edit-basic'));
    echo $this->Form->input('tease', array('class'=>'edit-basic'));
    echo $this->Form->input('description', array('rows'=>6, 'cols'=>96));
    echo $this->Form->input('keywords', array('rows'=>6, 'cols'=>96));
    echo $this->Form->input('canonical', array('rows'=>2, 'cols'=>96));
    echo $this->Form->input('slug', array('rows'=>2, 'cols'=>96));
    echo $this->Form->input('status');
    echo $this->Form->submit();
    echo $this->Form->end();

?>
