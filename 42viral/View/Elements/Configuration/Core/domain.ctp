<?php

$scheme = env('https')?'https':'http';

echo $this->Form->inputs(array(
        'legend'=>'Domain Settings',

        'Domainscheme.id'=>array('value'=>'Domain.scheme', 'type'=>'hidden'),
        'Domainscheme.value'=>array(
            'label'=>'Domain Scheme', 
            'value'=> empty($this->data['Domainscheme'][''])?$scheme:$this->data['Domainscheme'][''],
            'div'=> array('class'=>'input required')
        ),

        'Domainhost.id'=>array('value'=>'Domain.host', 'type'=>'hidden'),
        'Domainhost.value'=>array('label'=>'Domain Host', 
            'value'=>
                empty($this->data['Domainhost'][''])?env('SERVER_NAME'):$this->data['Domainhost'][''],
            'div'=> array('class'=>'input required')
        )

    ));
