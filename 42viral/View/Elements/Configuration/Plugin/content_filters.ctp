<?php 
    echo $this->Form->inputs(array(
            'legend'=>'Antispam Service',
            'ContentFiltersAntispamService.id'=>array(
                'value'=>'ContentFilters.AntispamService', 'type'=>'hidden'),

            'ContentFiltersAntispamService.value'=>array(
                'options'=>Configure::read('Picklist.ContentFilter.AntispamServices'), 
                'label'=>'Antispam Service'),
        ));

    echo $this->Form->inputs(array(
            'legend'=>'Akismet Settings',
            'ContentFiltersAkismetkey.id'=>array('value'=>'ContentFilters.Akismet.key', 'type'=>'hidden'),

            'ContentFiltersAkismetkey.value'=>array('label'=>'Akismet Key'),
        ));   
?>