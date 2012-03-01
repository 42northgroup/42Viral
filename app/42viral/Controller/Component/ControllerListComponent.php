<?php
/**
 * @todo find out where Lubo got this script and give appropriate credit
 */


class ControllerListComponent extends Component {
    
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
    
    public function get_plugins()
    {
        $pluginDirs = App::objects('plugin', null, false);
       
        foreach ($pluginDirs as $pluginDir){
            
            $pluginClasses = App::objects('controller', APP.'Plugin'. DS .$pluginDir. DS .'Controller', false);
            $plugins = array();
            
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
    
    public function get_all()
    {
        return array_merge($this->get(), $this->get_plugins());
    }
}
?>
