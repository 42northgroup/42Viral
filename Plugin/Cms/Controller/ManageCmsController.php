<?php
App::uses('Utility', 'Lib');
class ManageCmsController extends CmsAppController {
    
    public $uses = array('Configuration');
    
    public function admin_index(){
        $this->__adminEdit();
    }
    
    public function __adminEdit(){
        if(!empty($this->data)){
            $data = Utility::pluginConfigWrite($this->data);
            if($this->Configuration->saveAll($data)){
                $this->Session->setFlash('Your configuration has been saved', 'success');
            }else{
                $this->Session->setFlash('Your configuration couldn not be saved', 'error');
            }
        }
        
        $config = $this->Configuration->find('all');
        $this->request->data = Utility::pluginConfigRead($config);
    }
    
    
    
}