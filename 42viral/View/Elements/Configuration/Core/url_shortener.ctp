<?php
echo $this->Form->inputs(array(
    'legend'=>'URL Shortener',

    'ShortURLscheme.id'=>array('value'=>'ShortUR.scheme', 'type'=>'hidden'),
    'ShortURLscheme.value'=>array('label'=>'Short URL Scheme'),

    'ShortURLhost.id'=>array('value'=>'ShortURL.host', 'type'=>'hidden'),
    'ShortURLhost.value'=>array('label'=>'Short URL Host'),

    'ShortURLPointerpage.id'=>array('value'=>'ShortURL.Pointer.page', 'type'=>'hidden'),
    'ShortURLPointerpage.value'=>array('label'=>'Page Pointer'),        

    'ShortURLPointerblog.id'=>array('value'=>'ShortURL.Pointer.blog', 'type'=>'hidden'),
    'ShortURLPointerblog.value'=>array('label'=>'Blog Pointer'),   

    'ShortURLPointerpost.id'=>array('value'=>'ShortURL.Pointer.post', 'type'=>'hidden'),
    'ShortURLPointerpost.value'=>array('label'=>'Post Pointer'),   
));
        
