<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
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
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));

//A convenience route for accessing admin sections
Router::connect('/admin', array('prefix'=>'admin', 'controller' => 'system', 'action' => 'index'));

//Extra pretty URLs for content actions
Router::connect('/page', array('controller' => 'pages', 'action' => 'index'));
Router::connect('/page/:slug', array('controller' => 'pages', 'action' => 'view'), array('pass' => array('slug')));

Router::connect('/blog', array('controller' => 'blogs', 'action' => 'index'));
Router::connect('/blog/:slug', array('controller' => 'blogs', 'action' => 'view'), array('pass' => array('slug')));

Router::connect('/post', array('controller' => 'posts', 'action' => 'index'));
Router::connect('/post/:slug', array('controller' => 'posts', 'action' => 'view'), array('pass' => array('slug')));

//a convenience route for accesing a profile
Router::connect('/p/:username',
        array('controller' => 'profiles', 'action' => 'view'), array('pass' => array('username')));

Router::parseExtensions(); 

/**
 * Load all plugin routes.  See the CakePlugin documentation on 
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';
