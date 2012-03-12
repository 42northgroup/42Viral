<?php 

App::uses('AppController', 'Controller');
App::uses('Member', 'Lib');

/**
 * @package app
 * @subpackage app.core
 */
class ConfigurationManagerController extends AppController{
    
    /**
     *
     * @var array
     * @access public
     */
    public $uses = array();
    
    /**
     * Pulls a list of all plugins to allow for configuration 
     */
    public function admin_index(){
        
        $plugins = array();
        
        foreach(App::path('Plugin') as $path){
            foreach(scandir($path) as $dir){
                if(!in_array($dir, array('.', '..'))){
                    $plugins[] = is_dir($path . DS . $dir)?$dir:'';
                }
            }
        }
        
    }
}