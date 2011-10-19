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

echo $this->element('Navigation' . DS . 'local', array('section'=>'configuration', 'class'=>'config'));

echo $this->Html->div('config', 
        __('Create a database.')
        . "<br /> - "
        . __("You will need the database name as well as a username and password.")
        . "<br /> - "
        . __("We reccomend providing non-root credentials for production sites."));

echo $this->Html->link(__('Run setup shell'), '/setup/setup_shell',
        array('class'=>(in_array('setup_shell.txt', $completed)?' setup-complete':'config')));

echo $this->Html->link(__('Configure the database'), '/setup/xml_database', 
        array('class'=>(in_array('setup_xml_database.txt' ,$completed)?' setup-complete':'config')));

echo $this->Html->link('Configure core', '/setup/xml_core', 
        array('class'=>(in_array('setup_xml_core.txt' ,$completed)?' setup-complete':'config')));

echo $this->Html->link('Configure hashes', '/setup/xml_hash', 
        array('class'=>(in_array('setup_xml_hash.txt' ,$completed)?' setup-complete':'config')));

echo $this->Html->link('Configure the site', '/setup/xml_site', 
        array('class'=>(in_array('setup_xml_database.txt' ,$completed)?' setup-complete':'config')));

echo $this->Html->link('Configure third party APIs', '/setup/xml_third_party', 
        array('class'=>(in_array('setup_xml_third_party.txt' ,$completed)?' setup-complete':'config')));

echo $this->Html->link('Build configuration files', '/setup/process',
        array('class'=>(in_array('setup_process.txt' ,$completed)?' setup-complete':'config')), 
        'Are you sure?\n'
        . 'This will overwrite your exisiting configuration files.'
        );

echo $this->Html->link('Build the database', '/setup/build_database', 
        array('class'=>(in_array('setup_build_database.txt' ,$completed)?' setup-complete':'config')));

echo $this->Html->link('Import core data', '/setup/import', 
        array('class'=>(in_array('setup_import.txt' ,$completed)?' setup-complete':'config')));

echo $this->Html->link('Initialize ACLs', '/setup/acl',
        array('class'=>(in_array('setup_acl.txt' ,$completed)?' setup-complete':'config')),
        'Are you sure?\n'
        . 'This will reset all ACL (ARO/ACO) permissions.\n'
        . 'We do not recoomend this be done once a site has gone into production!\n'
        );

echo $this->Html->link('Set permissions', '/setup/give_permissions',
        array('class'=>(in_array('setup_give_permissions.txt' ,$completed)?' setup-complete':'config')));

echo $this->Html->link('Create root', '/setup/configure_root',
        array('class'=>(in_array('setup_configure_root.txt' ,$completed)?' setup-complete':'config')));

echo $this->Html->tag('h4', __('Optional'), array('style'=>'text-align: center;'));

echo $this->Html->link('Import demo data', '/setup/import_demo', array('class'=>'config'), 
        'Are you sure?\n'
        . 'This will populate the database with demo data.\n'
        . 'This is not reccomended for a production site.'
        );

echo $this->Html->link('Back up configuration files', '/setup/backup', array('class'=>'config'));
?>