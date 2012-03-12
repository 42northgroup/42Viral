<?php 
    echo $this->Form->create(null, array()); 
    echo $this->Form->inputs(array(
            'legend'=>'Antispam Service',
            'AnitspamService.id'=>array('value'=>'ContentFilters.AntispamService', 'type'=>'text'),
        
            'AnitspamService.key'=>array(
                'options'=>Configure::read('Picklist.ContentFilter.AntispamServices'), 
                'label'=>'Antispam Service'),
        
            'AnitspamService.plugin'=>array('value'=>'ContentFilters'),
        ));
    
    echo $this->Form->inputs(array(
            'legend'=>'Akismet',
            'Akismet.id'=>array('value'=>'Akismet.key', 'type'=>'text'),
        
            'AnitspamService.key'=>array(
                'options'=>Configure::read('Picklist.ContentFilter.AntispamServices'), 
                'label'=>'Antispam Service'),
        
            'AnitspamService.plugin'=>array('value'=>'ContentFilters'),
        ));   
    
    echo $this->Form->submit();
    echo $this->Form->end();
?>
