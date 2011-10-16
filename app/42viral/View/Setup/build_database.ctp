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


echo __('Use your DBMS to add your new database, then invoke a cake shell to build your database');

echo $this->Html->link('Initialize ACLs', '/setup/acl',
        array('class'=>(in_array('setup_acl.txt' ,$completed)?' setup-complete':'config')),
        'Are you sure?\n'
        . 'This will reset all ACL (ARO/ACO) permissions.\n'
        . 'We do not recoomend this be done once a site has gone into production!\n'
        );