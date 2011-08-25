<?php

App::uses('AppController', 'Controller');

/**
 *
 */
abstract class PrivilegesAbstractController extends AppController {
    
    public $components = array('ControllerList');
    
    public $uses = array('Person', 'Aro', 'Aco', 'AclGroup');
    

    public function beforeFilter()
    {
        $this->auth(array());
    }
    
    /**
     * Build the initial ACOs table, create an ARO entry for 
     * user "root" and gives him all permissions
     * 
     * @author Lyubomir R Dimov <lrdimov@yahoo.com>
     */
    public function admin_build_initial_acl()
    {
       $controllers = $this->ControllerList->get();
       
       $this->Acl->Aco->create(array('alias'=>'root',0,0));
       $this->Acl->Aco->save();
       
       $this->Acl->Aro->create(array(            
            'model'=>'User',
            'foreign_key'=>'4e27efec-ece0-4a36-baaf-38384bb83359',
            'alias'=>'root', 0, 0));
        
        $this->Acl->Aro->save();
       
       foreach($controllers as $key => $value){
            foreach($controllers[$key] as $action){
                $this->Acl->Aco->create(array(
                    'parent_id'=>1,
                    'alias'=>$key.'-'.$action,0,0
                ));
                $this->Acl->Aco->save();
                
                $this->Acl->allow('root', $key.'-'.$action, '*');
                
            }
        }
        

        $this->Acl->Aro->create(array(            
            'model'=>'User',
            'foreign_key'=>'4e27efec-ece0-4a36-baaf-38384bb83359',
            'alias'=>'root', 0, 0));
        
        $this->Acl->Aro->save();

                
        $this->redirect('/admin/privileges/user_privileges/root');

    }
    
    
    /**
     * Builds a permissions grid for a specific user and allows for permissions
     * to be granted and denied to said user
     * 
     * @author Lyubomir R Dimov <lrdimov@yahoo.com>
     * @param String $username 
     */
    public function admin_user_privileges($username){
        
        $controllers = $this->ControllerList->get();
        $this->set('username', $username);
        $this->set('controllers', $controllers);
        $this->set('person', $this->Person->findByUsername($username));
        
        $acos = $this->Aco->find('list', array(
            'fields' => array('Aco.id', 'Aco.alias')
        ));
        
        $acl_groups = $this->Aro->find('list', array(
            'conditions' => array('Aro.model' => 'AclGroup'),
            'fields' => array('Aro.id', 'Aro.alias')
        ));
        
        $this->set('acl_groups', $acl_groups);
        
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
        
        $this->set('privileges', $this->fetchPrivileges($username));
        
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
    
    /**
     * Attaches a user to an acl_group and has him inherit the 
     * permissions of the group 
     * 
     * @author Lyubomir R Dimov <lrdimov@yahoo.com>
     */
    public function admin_join_group(){
        
        if(!empty ($this->data)){
            $aro = $this->Aro->findByAlias($this->data['JoinGroup']['user_alias']);
            $aro['Aro']['parent_id'] = $this->data['JoinGroup']['groups'];
            
            unset($aro['Aro']['lft']);
            unset($aro['Aro']['rght']);
            
            $this->Acl->Aro->save($aro['Aro']);
            
            $controllers = $this->ControllerList->get();
            
            foreach($controllers as $key => $val){
                foreach($controllers[$key] as $index => $action){
                    
                    $this->Acl->inherit($this->data['JoinGroup']['user_alias'],$key.'-'.$action,'*');
                }
            }
            
            $this->redirect('/admin/privileges/user_privileges/'.$this->data['JoinGroup']['user_alias']);            
            
        }
        
        
    }
    
    /**
     * Returns all ACL privileges for a given user
     * 
     * @author Lyubomir R Dimov <lrdimov@yahoo.com>
     * @param String $username
     * @return array 
     */
    public function fetchPrivileges($username)
    {
        $aro = $this->Aro->findByAlias($username);
        if( $aro['Aro']['model']=='AclGroup' ){
            $this->set('is_group',1);
        }
                
        if( $aro['Aro']['parent_id'] != null ){
            $aro_group = $this->Aro->findById($aro['Aro']['parent_id']);            
        }
        
        $privileges = array();
        if(!empty ($aro)){
            for ($x=0; $x<count($aro['Aco']); $x++){
                foreach($aro['Aco'][$x]['Permission'] as $key => $val){
                    
                    if(!in_array($key, array('id', 'aro_id', 'aco_id'))){

                        $controller_action = explode('-', $aro['Aco'][$x]['alias']);
                        $perm = str_ireplace('_', '', $key);
                        
                        if($val != 0){
                            $privileges[$controller_action[0]][$controller_action[1]][$perm] = $val;
                        }else{
                            $privileges[$controller_action[0]][$controller_action[1]][$perm] = 
                                            isset($aro_group['Aco'][$x])?$aro_group['Aco'][$x]['Permission'][$key]:0;
                        }
                    }
                }
            }
            
        }
        
        return $privileges;
    }
    
}
?>
