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
 
    function connectionTest($server, $port = 80){    
        $fp = fsockopen($server,$port,$errno,$errstr,10);
        if(!$fp)
        {
                return "ERROR: $errno - $errstr";
        }
        else
        {
                return "Connection Test was successful - no errors on Port ".$port." at ".$server;
                fclose($fp);
        }
    }
    
    $servers = array(
        '66.135.58.61',
        '72.233.69.89',
        '72.233.69.88',
        '66.135.58.62',
        'rest.akismet.com'
    );
    
    foreach($servers as $server){
        echo connectionTest($server) .'<br />';
    }