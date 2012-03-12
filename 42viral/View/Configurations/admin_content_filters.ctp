<?php 
    echo $this->Form->create(null, array('class'=>'conversation')); 
    echo $this->Form->inputs(array(
            'legend'=>'Antispam Service',
            'AnitspamService.id'=>array('value'=>'ContentFilters.AntispamService', 'type'=>'text'),
        
            'AnitspamService.key'=>array(
                'options'=>Configure::read('Picklist.ContentFilter.AntispamServices'), 
                'label'=>'Antispam Service'),
        ));
    
    echo $this->Form->inputs(array(
            'legend'=>'Akismet',
            'Akismet.id'=>array('value'=>'ContentFilters.Akismet.key', 'type'=>'text'),
        
            'Akismet.key'=>array('label'=>'Akismet Key'),
        ));   
    
    echo $this->Form->submit();
    echo $this->Form->end();
?>
