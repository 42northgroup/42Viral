<?php
/**
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

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
