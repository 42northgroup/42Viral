<?php
/**
 * Provides controll logic for managing user privledges
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package       42viral\Person\User
 */

App::uses('AppController', 'Controller');
/**
 * Provides controll logic for managing user privledges
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @package 42viral\Person\User
 */
 class PrivilegesController extends AppController {

    /**
     * Components
     * @var array
     * @access public
     */
    public $components = array('ControllerList');

    /**
     * Model this controller uses
     * @var array
     * @access public
     */
    public $uses = array('Person', 'Aro', 'Aco', 'AclGroup');


    /**
     * beforeFilter
     * @access public
     */
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
       //get a list of all controllers and their actions in the system(including plugins)
       $controllers = $this->ControllerList->get_all();

       $this->Acl->Aco->create(array('alias'=>'root'));
       $this->Acl->Aco->save();

       //create the ARO for the root user
       $this->Acl->Aro->create(array(
            'model'=>'User',
            'foreign_key'=>'4e27efec-ece0-4a36-baaf-38384bb83359',
            'alias'=>'root',
            'parent_id' => null));

        $this->Acl->Aro->save();

       //loop through all controllers and actions, create ACL for each action and give root persmissions for that ACL
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
    public function admin_user_privileges($username)
    {
        //get a list of all main controllers and their actions
        $controllers = $this->ControllerList->get();

        //get a list of Plugin controllers and their actions
        $plugins = $this->ControllerList->get_plugins();

        $this->set('username', $username);

        $acos = $this->Aco->find('list', array(
            'fields' => array('Aco.id', 'Aco.alias')
        ));

        $acl_groups = $this->Aro->find('list', array(
            'conditions' => array('Aro.model' => 'Group'),
            'fields' => array('Aro.id', 'Aro.alias')
        ));

        $this->set('acl_groups', $acl_groups);

        //loop through all main controllers and their actions
        foreach($controllers as $key => $val){
            foreach($controllers[$key] as $index => $action){

                //if controller_action ACL does not exist, create it
                if( !in_array($key.'-'.$action, $acos) ){
                    $this->Acl->Aco->create(array(
                        'parent_id'=>1,
                        'alias'=>$key.'-'.$action,0,0
                    ));

                    $this->Acl->Aco->save();
                }
            }
        }

        //loop through all Plugin controllers and their actions
        foreach($plugins as $plugin){
            foreach($plugin as $key => $val){
                foreach($plugin[$key] as $index => $action){

                    //if controller_action ACL does not exist, create it
                    if( !in_array($key.'-'.$action, $acos) ){
                        $this->Acl->Aco->create(array(
                            'parent_id'=>1,
                            'alias'=>$key.'-'.$action,0,0
                        ));

                        $this->Acl->Aco->save();
                    }
                }
            }
        }


        $this->set('plugins', $plugins);
        $this->set('controllers', $controllers);
        $this->set('privileges', $this->fetchPrivileges($username));

        if(!empty ($this->data)){

            $aro_group = false;

            $aro = $this->Aro->findByAlias($username);

            //check if the permission we are setting are for a group
            if( $aro['Aro']['model']=='Group' ){

                $aro_group = true;

                //get a list of all group members
                $group_members = $this->Aro->find('list', array(
                    'conditions' => array('Aro.parent_id' => $aro['Aro']['id']),
                    'fields' => array('Aro.id', 'Aro.alias')
                ));
            }

            //loop through all submitted controller->actions and give/take appropriate permissions to the user
            foreach($this->data as $controller => $action){
                if($controller != '_Token'){

                    //loop through each permission
                    foreach ($this->data[$controller] as $function => $permission){

                        //loop through each controller->action
                        foreach ($this->data[$controller][$function] as $perm => $value){

                            //give or take away the permission
                            if($value == 1){
                                $this->Acl->allow($username,$controller.'-'.$function, $perm);
                            }elseif($value == 0){
                                $this->Acl->deny($username,$controller.'-'.$function, $perm);
                            }

                            //check if we are dealing with permissions for a group
                            if($aro_group == true){

                                //loop through all group members and have them re-inherit permissions from their group
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