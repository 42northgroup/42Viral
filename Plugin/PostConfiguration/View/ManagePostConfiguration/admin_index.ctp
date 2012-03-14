<h1>Post Configuration Plugin</h1>
<p>Deals with non-plugin post setup configuration.</p>
<?php 

    echo $this->Form->create(null, array('class'=>'conversation')); 
    
    echo $this->Form->inputs(array(
            'legend'=>'Google Tools',
        
            'GooglesetAccount.id'=>array('value'=>'Google.setAccount', 'type'=>'hidden'),
            'GooglesetAccount.value'=>array('label'=>'Google Analytics Tracking Code'),
        ));

    echo $this->Form->submit();