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
App::uses('Utility', 'Lib');
/**
 * Provides a means for managing manageable plugins
 * 
 * @package Plugin.PluginConfiguration
 * @subpackage Plugin.PluginConfiguration.Controller
 * @author Jason D Snider 
 */
class ConfigurationsController extends AppController{
    
    /**
     *
     * @var array
     * @access public
     */
    public $uses = array('Configuration');
    
    /**
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();
    }
    
    /**
     * Pulls a list of all plugins to allow for configuration 
     * @return void
     * @access public
     */
    public function admin_index(){
        
        //Initialize an array for storing the plugins
        $plugins = array();
        
        //Scan all Plugin paths
        foreach(App::path('Plugin') as $path){
            //Scan each path identify all of the plugin directories
            foreach(scandir($path) as $dir){ 
                //Identify all of the view directories
                foreach(App::path('View') as $viewPath){
                    //Scan all View paths. We are looking for Configurations directoies  
                    foreach(scandir($viewPath) as $viewDir){
                        //If we find a Configurations directory see if the current Plugin has a corrsponding file
                        //If it does we will provide a link, otherwise we will provide a static label
                        if(in_array($viewDir, array('Configurations'))){
                            if(!in_array($dir, array('.', '..', 'empty'))){
                                
                                $view = Inflector::underscore($dir);
                                
                                //Foreach management controller located add enough data to build a link to the array
                                if(is_file($viewPath . $viewDir . DS . "admin_{$view}.ctp")){

                                    $plugins[] = array(
                                        'label'=>$dir, 
                                        'url'=> "/admin/configurations/{$view}"
                                    );

                                }else{ 
                                    //If we can't find a management controller, all we want is a label
                                    $plugins[] = array('label'=>$dir);
                                } 

                            }
                        }
                    }
                }
            }
        }

        $this->set('plugins', $plugins);
        $this->set('title_for_layout', 'Configuration Manager');
    }
    
    /**
     * Provides an action for configuring content filters
     * @return void
     * @access public
     */
    public function admin_configuration(){
        $this->__adminEdit();
        $this->set('title_for_layout', "Content Filter Configuration");  
    }
    
    /**
     * Provides an action for configuring content filters
     * @return void
     * @access public
     */
    public function admin_content_filters(){
        $this->__adminEdit();
        $this->set('title_for_layout', "Content Filter Configuration");  
    }
    
    /**
     * Common edit functionality for dealing with configuration forms
     * @return void
     * @access public
     */
    private function __adminEdit(){
        if(!empty($this->data)){
            
            $data = Utility::pluginConfigWrite($this->data);
            
            if($this->Configuration->saveAll($data)){
                $this->Session->setFlash('Your configuration has been saved', 'success');
            }else{
                $this->Session->setFlash('Your configuration could not be saved', 'error');
            }
        }
        
        $config = $this->Configuration->find('all');
        $this->request->data = Utility::pluginConfigRead($config);
    }    
    
    
    
    
}