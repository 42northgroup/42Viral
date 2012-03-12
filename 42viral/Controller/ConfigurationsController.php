<?php 

App::uses('AppController', 'Controller');
App::uses('Parser', 'Lib');

/**
 * @package app
 * @subpackage app.core
 */
class ConfigurationsController extends AppController{
    
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
        
        $plugins = array();
        
        foreach(App::path('Plugin') as $path){
            foreach(scandir($path) as $dir){
                if(!in_array($dir, array('.', '..'))){
                    $plugins[] = is_dir($path . DS . $dir)?$dir:'';
                }
            }
        }
        
        $this->set('plugins', $plugins);
        $this->set('title_for_layout', 'Installed Plugins');
    }
    
    public function admin_content_filters(){
        
        if(!empty($this->data)){
            $data = Parser::pluginConfigWrite($this->data);
            if($this->Configuration->saveAll($data)){
                $this->Session->setFlash('Your configuration has been saved', 'success');
            }else{
                $this->Session->setFlash('Your configuration couldn not be saved', 'error');
            }
        }
        
        $config = $this->Configuration->find('all');
        $this->request->data = Parser::pluginConfigRead($config);
    }
}