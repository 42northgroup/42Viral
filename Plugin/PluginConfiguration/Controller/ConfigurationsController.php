<?php 
/**
 * Copyright 2012, Jason D Snider (https://jasonsnider.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, Jason D Snider (https://jasonsnider.com)
 * @link https://jasonsnider.com
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppController', 'Controller');
App::uses('Utility', 'PluginConfiguration.Lib');
/**
 * Provides a means for managing manageable plugins
 * 
 * @package Plugin.PluginConfiguration
 * @subpackage Plugin.PluginConfiguration.Controller
 * @author Jason D Snider 
 */
class ConfigurationsController extends PluginConfigurationAppController{
    
    /**
     *
     * @var array
     * @access public
     */
    public $uses = array('Configuration');
    
    /**
     * Pulls a list of all plugins to allow for configuration 
     */
    public function admin_index(){
        
        //Initialize an array for storing the plugins
        $plugins = array();
        
        //Scan all Plugin paths
        foreach(App::path('Plugin') as $path){
            //Scan each path identify all of the plugin directories
            foreach(scandir($path) as $dir){ 
                
                //exclude unwanted directoies
                if(!in_array($dir, array('.', '..'))){
                    
                    //Look for a managemnet controller matching our namming conventions
                    if(is_dir($path . DS . $dir)){
                        
                        //Foreach management controller located add enough data to build a link to the array
                        if(is_file($path . DS . $dir . DS . 'Controller' . DS . "Manage{$dir}Controller.php")){
                            $plugins[] = array(
                                'label'=>$dir, 
                                'url'=> '/admin/' . Inflector::underscore($dir) 
                                                  . '/manage_' 
                                                  . Inflector::underscore($dir)
                            );
                            
                        }else{
                            //If we can't find a management controller, all we want is a label
                            $plugins[] = array('label'=>$dir);
                        }
                        
                    }
                }
            }
        }

        $this->set('plugins', $plugins);
        $this->set('title_for_layout', 'Installed Plugins');
    }
}