<h1>Post Configuration Plugin</h1>
<p>Deals with non-plugin post setup configuration.</p>
<?php 

    echo $this->Form->create(null, array('class'=>'conversation')); 
    
    echo $this->Form->inputs(array(
            'legend'=>'Google Analytics',
            'GooglesetAccount.id'=>array('value'=>'Google.setAccount', 'type'=>'hidden'),
            'GooglesetAccount.value'=>array('label'=>'Tracking Code'),
        ));
    
    echo $this->Form->inputs(array(
            'legend'=>'Google Webmaster Tools',
            'GoogleSiteVerification.id'=>array('value'=>'Google.SiteVerification', 'type'=>'hidden'),
            'GoogleSiteVerification.value'=>array('label'=>'Verification ID'),
        ));
    
    echo $this->Form->inputs(array(
            'legend'=>'Google Apps',
            'GoogleAppsdomain.id'=>array('value'=>'Google.Apps.domainGoogle.SiteVerification', 'type'=>'hidden'),
            'GoogleAppsdomain.value'=>array('label'=>'Domain'),
        ));
    
    echo $this->Form->submit();