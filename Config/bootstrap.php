<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as 
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Plugin' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'Model' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'View' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'Controller' => array('/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'Model/Datasource' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'Model/Behavior' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'Controller/Component' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'View/Helper' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'Vendor' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'Console/Command' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */

/**
 * Custom Inflector rules, can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */

CakePlugin::loadAll(array(
            'ContentFilters'=>array('bootstrap' => true),
            'Seo'=>array('bootstrap' => true)
        ));

App::build(array(
    
        'Controller' => array(
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Controller' . DS
        ),
    
        'Controller/Component' => array(
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Controller' . DS . 'Component' . DS,
        ),
    
        'Console' => array(
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Console' . DS
        ),
    
        'Console/Command' => array(
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Console' . DS . 'Command' . DS
        ),
    
        'Console/Command/Task' => array(
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Console' . DS . 'Command' . DS . 'Task' . DS
        ),
    
        'Lib' => array(
            ROOT . DS . APP_DIR . DS . 'Lib' . DS,
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Lib' . DS,
        ),   
    
        'Model' => array(
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Model'  . DS
        ),
    
        'Model/Behavior' => array(
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Model' . DS . 'Behavior' . DS,
        ),
    
        'Model/Datasource' => array(
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Model' . DS . 'Datasource' . DS
        ),
    
        'Model/Datasource/Database' => array(
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Model' . DS . 'Datasource' . DS . 'Database' . DS
        ),
    
        'Plugin' => array(
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Plugin' . DS
        ),
    
        'vendors' => array(
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Vendor' . DS
        ),
    
        'View' => array(
            //We want the native cake structure to ovverride 42Viral's views
            ROOT . DS . APP_DIR . DS . 'View' . DS,
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'View' . DS,
        ),    
    
        'View/Helper' => array(
            //We want the native cake structure to ovverride 42Viral's helpers
            ROOT . DS . APP_DIR . DS . 'View' . DS . 'Helper' . DS,
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'View' . DS . 'Helper' . DS,
        ),   
    
        'locales' => array(
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Locale' . DS
        )
    
    ));

require(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . 'database.php');
require(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . 'site.php');
require(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . 'hash.php');
require(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . 'core.php');
require(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . 'third_party.php');
require(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'app.php');
