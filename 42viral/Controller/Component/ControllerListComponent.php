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
 * @package       42viral\app
 */

/**
 * Retrives a list of controllers and actions in the system
 * @package app
 * @subpackage app.core
 * @author Lyubomir R Dimov <lrdimov@yahoo.com>
 */
class ControllerListComponent extends Component {

    /**
     * Returns a list of the main controllers and actions
     *
     * @access public
     * @return array
     * @link https://github.com/cakebaker/controller-list-component
     */
    public function get() {

        $controllerClasses = App::objects('controller', null, false);

        $parentActions = get_class_methods('AppController');

        foreach($controllerClasses as $controller) {

            if (strpos($controller,'App') === false && strpos($controller,'Abstract') === false) {
                $controller = str_ireplace('Controller', '', $controller);
                App::import('Controller', $controller);
                $actions = get_class_methods($controller.'Controller');

                foreach($actions as $k => $v) {
                    if ($v{0} == '_') {
                        unset($actions[$k]);
                    }
                }


                $controllers[$controller] = array_diff($actions, $parentActions);
            }
        }

        return $controllers;
    }

    /**
     * Returns a list of controllers and actions belonging to plugins
     *
     * @access public
     * @return array
     */
    public function get_plugins()
    {
        $pluginDirs = App::objects('plugin', null, false);
        $plugins = array();

        foreach ($pluginDirs as $pluginDir){

            $pluginClasses = App::objects('controller', APP.'Plugin'. DS .$pluginDir. DS .'Controller', false);

            App::import('Controller', $pluginDir.'.'.$pluginDir.'App');
            $parentActions = get_class_methods($pluginDir.'AppController');

            foreach($pluginClasses as $plugin) {

                if (strpos($plugin,'App') === false) {

                    $plugin = str_ireplace('Controller', '', $plugin);
                    App::import('Controller', $pluginDir.'.'.$plugin);
                    $actions = get_class_methods($plugin.'Controller');

                    foreach($actions as $k => $v) {
                        if ($v{0} == '_') {
                            unset($actions[$k]);
                        }
                    }
                    
                    $plugins[$plugin] = array_diff($actions, $parentActions);
                }
            }
        }

        return $plugins;
    }

    /**
     * Retrives a list of all controllers and action(including plugins)
     *
     * @access public
     * @return array
     */
    public function get_all()
    {
        return array_merge($this->get(), $this->get_plugins());
    }
}
?>