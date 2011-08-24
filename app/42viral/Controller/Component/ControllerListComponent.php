<?php
/**
 * @todo find out where Lubo got this script and give appropriate credit
 */


class ControllerListComponent extends Component {
    
    public function get() {
        $controllerClasses = App::objects('controller');

        
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
                
                $parentActions = get_class_methods('AppController');
                
                $controllers[$controller] = array_diff($actions, $parentActions);                
            }
        }
        
        return $controllers;
    }
}
?>
