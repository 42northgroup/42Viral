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
 * @package       app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'plugins' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'models' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'views' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'controllers' => array('/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'datasources' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'behaviors' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'components' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'helpers' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'vendors' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'shells' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */
App::build(array(
        'Controller' => array(ROOT . DS . APP_DIR . DS . 'Controller' . DS . 'Abstract' . DS ),
        'Model' => array(ROOT . DS . APP_DIR . DS . 'Model' . DS . 'Abstract' . DS )
    
    ));


/**
 * Image and File system write paths
 */
define('IMAGE_WRITE_PATH',  ROOT .DS . APP_DIR . DS . WEBROOT_DIR . DS . 'img' . DS . 'people' . DS);
define('FILE_WRITE_PATH',  ROOT .DS . APP_DIR . DS . WEBROOT_DIR . DS . 'files' . DS . 'people' . DS);

/**
 * Image and File web read paths
 */
define('IMAGE_READ_PATH', '/img/people/');
define('FILE_READ_PATH', '/files/people/');

/**
 * Set the paths for running test cases
 */
define('TEST_CASE_DIR', APP_DIR . DS . 'Test' . DS . 'Case');
define('TEST_MODEL', ROOT . DS . TEST_CASE_DIR . DS . 'Model' . DS);
define('TEST_CONTROLER', ROOT . DS . TEST_CASE_DIR . DS . 'Controller' . DS);
define('TEST_VIEW', ROOT . DS . TEST_CASE_DIR . DS . 'View' . DS);

/**
 * As of 1.3, additional rules for the inflector are added below
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */
