<h1>CMS Plugin</h1>

<?php 

    echo $this->Form->create(null, array('class'=>'conversation')); 
    
    echo $this->Form->inputs(array(
            'legend'=>'Comment Engine',
        
            'Commentengine.id'=>array('value'=>'Comment.engine', 'type'=>'hidden'),
            'Commentengine.value'=>array(
                'options'=>Configure::read('Picklist.Cms.comment_engines'), 
                'label'=>'Comment Engine')
        ));
    
    echo $this->Form->inputs(array(
            'legend'=>'Disqus',
            'Disqusshortname.id'=>array('value'=>'Disqus.shortname', 'type'=>'hidden'),
            'Disqusshortname.value'=>array('label'=>'Disqus Short Name'),
        
            'Disqus.developer.id'=>array('value'=>'Disqus.developer', 'type'=>'hidden'),
            'Disqus.developer.value'=>array('label'=>'Disqus. Developer'),
        
        ));

    echo $this->Form->submit();