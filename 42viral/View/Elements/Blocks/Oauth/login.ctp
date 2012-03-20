<?php
/**
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
 
echo $this->Html->link('', "/oauth/google_connect", array('class'=>'oauth-button google-plus'));
echo $this->Html->link('', '/oauth/linkedin_connect', array('class'=>'oauth-button linkedin'));
echo $this->Html->link('', '/oauth/facebook_connect', array('class'=>'oauth-button facebook'));
echo $this->Html->link('', '/oauth/twitter_connect', array('class'=>'oauth-button twitter'));
