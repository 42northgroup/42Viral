<?php
class PostConfigurationAppController extends AppController {
    
    /**
     * Has the platform identified itself as 42Viral?
     * @var boolean 
     * @access public
     */
    public $hasConfigurationPlugin = array();
    
    /**
     * @return void
     * @access public 
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->hasConfigurationPlugin = Configure::read('Plugin.42viral.Configuration');
    }  
    
    /**
     * @return void
     * @access public 
     */
    public function beforeRender() {
        parent::beforeRender();
        if(!$this->hasConfigurationPlugin){
            die('Install the Configurations plugin to take advantage of the configuration UI');
        }
        
        $this->set('hasConfigurationPlugin ', $this->hasConfigurationPlugin);

    }     
}