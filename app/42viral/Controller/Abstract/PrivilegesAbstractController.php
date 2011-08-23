<?php

App::uses('AppController', 'Controller');

/**
 *
 */
abstract class PrivilegesAbstractController extends AppController {
    
    public $components = array('ControllerList');
    public $uses = array('Person', 'Aro', 'Aco');
    

    public function beforeFilter()
    {
        parent::beforeFilter();
        
        $this->Auth->allow('*');

    }
    
    
    public function admin_build_initial_acl()
    {
       $controllers = $this->ControllerList->get();
       
       foreach($controllers as $key => $value){
            foreach($controllers[$key] as $action){
                $this->Acl->Aco->create(array(
                    'parent_id'=>1,
                    'alias'=>$key.'-'.$action,0,0
                ));
                $this->Acl->Aco->save();
            }
        }
        
        $this->Acl->Aro->create(array(            
            'model'=>'User',
            'foreign_key'=>'4e27efec-ece0-4a36-baaf-38384bb83359',
            'alias'=>'root', 0, 0));
        
        $this->Acl->Aro->save();
        
        $this->redirect('/admin/privileges/user_privileges/root');
    }
    
    public function admin_user_privileges($username){
        
        $controllers = $this->ControllerList->get();
        $this->set('username', $username);
        $this->set('controllers', $controllers);
        $this->set('person', $this->Person->getPersonByUsername($username));
        
        $aro = $this->Aro->findByAlias($username);
        
        $acos = $this->Aco->find('list', array(
            'fields' => array('Aco.id', 'Aco.alias')
        ));
        
        foreach($controllers as $key => $val){
            foreach($controllers[$key] as $index => $action){
                
                if( !in_array($key.'-'.$action, $acos) ){
                    $this->Acl->Aco->create(array(
                        'parent_id'=>1,
                        'alias'=>$key.'-'.$action,0,0
                    ));
                    
                    $this->Acl->Aco->save();
                }
            }
        }
        
        foreach ($aro['Aco'] as $aco){
            foreach($aco['Permission'] as $key => $val){
                
                if(!in_array($key, array('id', 'aro_id', 'aco_id'))){
                    
                    $controller_action = explode('-',$aco['alias']);
                    $perm = str_ireplace('_', '', $key);
                    $privileges[$controller_action[0]][$controller_action[1]][$perm] = $val;
                }
            }
        }
        
        if(isset($privileges)){
            $this->set('privileges', $privileges);
        }
        
         
        if(!empty ($this->data)){
            foreach($this->data as $controller => $action){
                if($controller != '_Token'){
                    
                    foreach ($this->data[$controller] as $function => $permission){
                        
                        foreach ($this->data[$controller][$function] as $perm => $value){
                            
                            if($value == 1){
                                $this->Acl->allow($username,$controller.'-'.$function, $perm);
                            }elseif($value == 0){
                                $this->Acl->deny($username,$controller.'-'.$function, $perm);
                            }
                        }
                    }
                }
            }
            $this->redirect('/admin/privileges/user_privileges/'.$username);
        }
    }
    
}
?>
