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
//Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
//Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));

Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));

//Router::connect('/', array('controller' => 'pages', 'action' => 'home'));

Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));

Router::connect('/admin', array('prefix'=>'admin', 'controller' => 'system', 'action' => 'index'));

Router::connect('/page/:slug', array('controller' => 'pages', 'action' => 'view'), array('pass' => array('slug')));

Router::connect('/blog/:slug', array('controller' => 'blogs', 'action' => 'view'), array('pass' => array('slug')));

Router::connect('/post/:slug', array('controller' => 'posts', 'action' => 'view'), array('pass' => array('slug')));

Router::connect('/case/:id', array('controller' => 'cases', 'action' => 'view'), array('pass' => array('id')));

Router::connect('/p/:username',
        array('controller' => 'members', 'action' => 'view'), array('pass' => array('username')));

Router::connect(
    '/c/:slug',
    array('controller' => 'profile_companies', 'action' => 'view'),
    array('pass' => array('slug')
));

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