<?php
App::uses('Utility', 'Lib');
class ManagePostConfigurationController extends PostConfigurationAppController {
    
    public $uses = array('PluginConfiguration.Configuration');
    
    public function admin_index(){
        $this->__adminEdit();
    }
    
    public function __adminEdit(){
        if(!empty($this->data)){
            
            $readyForProduction = $this->data['Configuration']['readyForProduction'];
            unset($this->request->data['Configuration']);
            
            $data = Utility::pluginConfigWrite($this->data);
            
            foreach ($data as $row){
                $dataForValidation['Configuration'][$row['Configuration']['id']] = $row['Configuration']['value'];
            }
            
            $this->Configuration->set($dataForValidation);            
            
            if($readyForProduction==1 && !$this->Configuration->validates()){
                $errors = $this->Configuration->validationErrors;
                
                foreach ($errors as $key => $value){
                    $errors[str_ireplace('.', '', $key)] = $errors[$key][0];
                }
                $this->set('errors', $errors);
                
                $this->Session->setFlash('Your configuration couldn not be saved. Please fix the errors below','error');
            }else{
                if($this->Configuration->saveAll($data)){
                    $this->Session->setFlash('Your configuration has been saved', 'success');
                }else{
                    $this->Session->setFlash('Your configuration couldn not be saved', 'error');
                }
            }
        }
        
        $config = $this->Configuration->find('all');
        $this->request->data = Utility::pluginConfigRead($config);
    }
    
    
    
}