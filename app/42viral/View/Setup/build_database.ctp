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

/**
 * @author Jason D Snider <jason.snider@42viral.org>
 */


echo $this->Html->div('config',
        __("If you've already added your database, build the configuration files."
                . " Otherwise, create the new database."));

echo $this->Html->link('Build the configuration files', '/setup/process', 
        array('class'=>(in_array('setup_process.txt' ,$completed)?' setup-complete':'config')));