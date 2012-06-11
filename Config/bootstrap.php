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
    'AssetManager' => array('bootstrap' => true),
    'ContentFilters' => array('bootstrap' => true),
    'Docs' => array('bootstrap' => true, 'routes'=>true),
    'PicklistManager' => array('bootstrap' => true),
    'Seo' => array('bootstrap' => true)
));

/**
 * When searching multiple paths, CakePHP will stop on the first hit. Be sure to place an override path before a
 * primary path.
 */
App::build(array(

        'Controller' => array(
        	ROOT . DS . APP_DIR . DS . 'Controller' . DS,
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Controller' . DS
        ),

        'Controller/Component' => array(
        	ROOT . DS . APP_DIR . DS . 'Controller' . DS . 'Component' . DS,
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Controller' . DS . 'Component' . DS,
        ),

        'Console' => array(
        	ROOT . DS . APP_DIR . DS . 'Console' . DS,
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Console' . DS,
        	//DebugKit has no Config, so we will add the console path here
        	ROOT . DS . APP_DIR . DS . 'Plugin' . DS . 'DebugKit' . DS . 'Console' . DS
        ),

        'Console/Command' => array(
        	ROOT . DS . APP_DIR . DS . 'Console' . DS . 'Command' . DS,
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Console' . DS . 'Command' . DS
        ),

        'Lib' => array(
            ROOT . DS . APP_DIR . DS . 'Lib' . DS,
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Lib' . DS,
        ),

        'Model' => array(
        	ROOT . DS . APP_DIR . DS . 'Model'  . DS,
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Model'  . DS
        ),

        'Model/Behavior' => array(
        	ROOT . DS . APP_DIR . DS . 'Model' . DS . 'Behavior' . DS,
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Model' . DS . 'Behavior' . DS,
        ),

        'Model/Datasource' => array(
        	ROOT . DS . APP_DIR . DS . 'Model' . DS . 'Datasource' . DS,
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Model' . DS . 'Datasource' . DS
        ),

        'Model/Datasource/Database' => array(
        	ROOT . DS . APP_DIR . DS . 'Model' . DS . 'Datasource' . DS . 'Database' . DS,
            ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Model' . DS . 'Datasource' . DS . 'Database' . DS
        ),

        'vendors' => array(
        	ROOT . DS . APP_DIR . DS . 'Vendor' . DS,
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
        )

    ));

/**
 * Encoding method to use for encoding and decoding the setup state array structure
 *
 * Options:
 *     php_serialize
 *     json
 */
if (!defined('SETUP_STATE_ENCODING_METHOD')) {
    define('SETUP_STATE_ENCODING_METHOD', 'php_serialize');
}

/**
 * Your applications default scheme http or https
 * You may want to hard code this depending on your server's configuration
 * @var string
 */
Configure::write('Domain.scheme', (env('HTTPS')?'https':'http'));

/**
 * Your applications host domain exaomple.com, www.example.com, example.example.com, etc
 * You may want to hard code this depending on your server's configuration
 * @var string
 */
Configure::write('Domain.host', env('SERVER_NAME'));


// We only want to require these if the setup shell has been ran, we check this by testing for database.php
if(is_file(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . 'database.php')) {
    require_once(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . 'database.php');
    require_once(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . 'hash.php');
    require_once(ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . 'system.php');
}

// Bootstrap applications configruation path
if(is_file(ROOT . DS . APP_DIR . DS .'Config' . DS . 'application.php')) {
    require(ROOT . DS . APP_DIR . DS .'Config' . DS . 'application.php');
}else{
    require(ROOT . DS . APP_DIR . DS .'Config' . DS . 'application.default.php');
}

/**
 * Allows the Plugin to identify itself
 * @var string
 */
Configure::write('Plugin.42viral.Configuration', true);


/**
 * Provides a list of supported commenting engines
 * @var array
 */
Configure::write('Picklist.Cms.comment_engines',
        array(
            'native'=>'Native',
            'disqus'=>'Disqus')
        );

/**
 * Provides a list of supported Antispam Services
 * @var array
 */
Configure::write('Picklist.ContentFilter.AntispamServices',
        array(
            ''=>'None',
            'akismet'=>'Akismet')
        );