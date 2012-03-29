<?php

App::uses('AppController', 'Controller');

/**
 *
 */
 class PrivilegesController extends AppController {
    
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
     * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
     */
    public function admin_build_initial_acl()
    {
       $controllers = $this->ControllerList->get_all();
       
       $this->Acl->Aco->create(array('alias'=>'root'));
       $this->Acl->Aco->save();
       
       $this->Acl->Aro->create(array(            
            'model'=>'User',
            'foreign_key'=>'4e27efec-ece0-4a36-baaf-38384bb83359',
            'alias'=>'root',
            'parent_id' => null));
        
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
                
        $this->redirect('/admin/privileges/user_privileges/root');

    }
    
    

    /**
     * Builds a permissions grid for a specific user and allows for permissions
     * to be granted and denied to said user
     * 
     * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
     * @param String $username 
     */
    public function admin_user_privileges($username){
        
        $controllers = $this->ControllerList->get();
        $plugins = $this->ControllerList->get_plugins();
        
        $this->set('username', $username);
        
        $this->set('person', $this->Person->findByUsername($username));
       
        $acos = $this->Aco->find('list', array(
            'fields' => array('Aco.id', 'Aco.alias')
        ));
        
        $acl_groups = $this->Aro->find('list', array(
            'conditions' => array('Aro.model' => 'Group'),
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
        
        foreach($plugins as $key => $val){
            foreach($plugins[$key] as $index => $action){
                
                if( !in_array($key.'-'.$action, $acos) ){
                    $this->Acl->Aco->create(array(
                        'parent_id'=>1,
                        'alias'=>$key.'-'.$action,0,0
                    ));
                    
                    $this->Acl->Aco->save();
                }
            }
        }
        
        
        $this->set('plugins', $plugins);
        $this->set('controllers', $controllers);
        $this->set('privileges', $this->fetchPrivileges($username));
        
        if(!empty ($this->data)){
            
            $aro_group = false;
            
            $aro = $this->Aro->findByAlias($username);
            
            if( $aro['Aro']['model']=='Group' ){
                
                $aro_group = true;
                
                $group_members = $this->Aro->find('list', array(
                    'conditions' => array('Aro.parent_id' => $aro['Aro']['id']),
                    'fields' => array('Aro.id', 'Aro.alias')
                ));
            }
            
            foreach($this->data as $controller => $action){
                if($controller != '_Token'){
                    
                    foreach ($this->data[$controller] as $function => $permission){
                        
                        foreach ($this->data[$controller][$function] as $perm => $value){
                            
                            if($value == 1){
                                $this->Acl->allow($username,$controller.'-'.$function, $perm);
                            }elseif($value == 0){
                                $this->Acl->deny($username,$controller.'-'.$function, $perm);
                            }
                            
                            if($aro_group == true){
                                foreach ($group_members as $member){
                                    $this->Acl->inherit($member,$controller.'-'.$function, $perm);
                                }
                            }
                        }
                    }
                }
            }
            
            $this->redirect('/admin/privileges/user_privileges/'.$username);
        }
        
        $this->set('title_for_layout', 'User Privileges');
    }
    
    public function admin_aco_group($alias)
    {
        $controllers = $this->ControllerList->get_all();
        $acos = $this->Aco->find('list', array(
            'fields' => array('Aco.alias', 'Aco.parent_id')
        ));
        $this->set('acos', $acos);
        
        $group = $this->Aco->findByAlias($alias);
        $this->set('group', $group);
        
        foreach($controllers as $key => $val){
            foreach($controllers[$key] as $index => $action){
                
                if( !array_key_exists($key.'-'.$action, $acos) ){
                    $this->Acl->Aco->create(array(
                        'parent_id'=>1,
                        'alias'=>$key.'-'.$action,0,0
                    ));
                    
                    $this->Acl->Aco->save();
                }
            }
        }
        
        foreach($acos as $key => $val){
            $aco_alias = explode('-',$key);
            
            if(isset($aco_alias[1]) && $aco_alias[1] == 'group' && $aco_alias[0].'-'.$aco_alias[1] != $alias){
                $controllers[$aco_alias[0]] = array();
                array_push($controllers[$aco_alias[0]], $aco_alias[1]);
            }
        }
        
        $this->set('controllers', $controllers);
    }
    
    public function admin_add_to_group($new_parent_id){
        
        if(!empty ($this->data)){
            
            $acos = $this->Aco->find('all', array(
                'contain' => array()
            ));
            
            foreach ($acos as $aco){
                $aco_alias = explode('-', $aco['Aco']['alias']);
                
                if($aco['Aco']['alias'] != 'root' && $aco['Aco']['id'] != $new_parent_id ){
                    
                    if($this->data[$aco_alias[0]][$aco_alias[1]] == 1){
                        
                        unset($aco['Aco']['lft']);
                        unset($aco['Aco']['rght']);

                        $aco['Aco']['parent_id'] = $new_parent_id;

                        $this->Acl->Aco->save($aco);
                    }else{
                        
                        unset($aco['Aco']['lft']);
                        unset($aco['Aco']['rght']);
                        $aco['Aco']['parent_id'] = 1; 

                        $this->Acl->Aco->save($aco);
                    }
                }
            }
            
                        
            $this->redirect($this->referer());            
            
        }
        
        
    }


    /**
     * Attaches a user to an acl_group and has him inherit the 
     * permissions of the group 
     * 
     * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
     */
    public function admin_join_group(){
        
        if(!empty ($this->data)){
            $aro = $this->Aro->findByAlias($this->data['JoinGroup']['user_alias']);
            $aro['Aro']['parent_id'] = $this->data['JoinGroup']['groups'];
            
            unset($aro['Aro']['lft']);
            unset($aro['Aro']['rght']);
            
            $this->Acl->Aro->save($aro['Aro']);
            
            $controllers = $this->ControllerList->get_all();
            
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
     * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
     * @param String $username
     * @return array 
     */
    public function fetchPrivileges($username)
    {
        $aro = $this->Aro->findByAlias($username);
        if( $aro['Aro']['model']=='Group' ){
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
                                            isset($aro_group['Aco'][$x])?$aro_group['Aco'][$x]['Permission'][$key]:-1;
                        }
                    }
                }
            }
            
        }
        
        return $privileges;
    }
            
}
?>
