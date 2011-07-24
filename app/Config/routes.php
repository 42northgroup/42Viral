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
 * @package       app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */

//Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
        
/**
 * We want the object_type be able to resolve content views
 */
Router::connect('/page/:slug', array('controller' => 'pages', 'action' => 'view'), array('pass' => array('slug')));

Router::connect('/blog/:slug', array('controller' => 'blogs', 'action' => 'view'), array('pass' => array('slug')));
 
Router::connect('/post/:slug', array('controller' => 'blogs', 'action' => 'post'), array('pass' => array('slug')));

Router::connect('/profile/:username', 
        array('controller' => 'members', 'action' => 'view'), array('pass' => array('username')));

/**
 * Setup extension parsing to prepare for web services.
 */
Router::parseExtensions('rss', 'json', 'xml');
