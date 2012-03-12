<?php 

App::uses('AppController', 'Controller');
App::uses('Member', 'Lib');

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
            $data = array();
            $x=0;
            foreach($this->data as $key=>$value){
                $data[$x]['Configuration']['id']=$value['id'];
                $data[$x]['Configuration']['key']=$value['key'];
                $x++;
            }
           //pr($data);
            if($this->Configuration->updateAll($this->data)){
                echo 'Saved';
            }
        }
    }
}