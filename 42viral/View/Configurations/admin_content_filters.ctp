<?php 
    echo $this->Form->create(null, array('class'=>'conversation')); 
    echo $this->Form->inputs(array(
            'legend'=>'Antispam Service',
            'ContentFiltersAntispamService.id'=>array('value'=>'ContentFilters.AntispamService', 'type'=>'text'),
        
            'ContentFiltersAntispamService.value'=>array(
                'options'=>Configure::read('Picklist.ContentFilter.AntispamServices'), 
                'label'=>'Antispam Service'),
        ));
    
    echo $this->Form->inputs(array(
            'legend'=>'Akismet',
            'ContentFiltersAkismetkey.id'=>array('value'=>'ContentFilters.Akismet.key', 'type'=>'text'),
        
            'ContentFiltersAkismetkey.value'=>array('label'=>'Akismet Key'),
        ));   
    
    echo $this->Form->submit();
    echo $this->Form->end();
?>
