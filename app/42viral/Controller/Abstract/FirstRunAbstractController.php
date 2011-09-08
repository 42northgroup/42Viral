<?php
/**
 * PHP 5.3
 * 
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('AppController', 'Controller');

/**
 * Provides a web interface for running the intial system setup
 * @author Jason D Snider <jsnider77@gmail.com>
 * @author Lyubomir R Dimov <lrdimov@yahoo.com>
 */
abstract class FirstRunAbstractController extends AppController {

    /**
     * Controller name
     * @var string
     * @access public
     */
    public $name = 'FirstRun';

    public $components = array('ControllerList');
    public $uses = array('Aco', 'AclGroup', 'Aro', 'Group', 'Person', 'User');


    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->auth(array('*'));
    }

    /**
     * The starting pont to the first run wizard
     * @return void
     * @access public
     */
    public function index(){
        
        $this->flash('Truncating all tables...', '/first_run/truncate');
    }
    
    /**
     * Cleans up any exisiting data
     * @return void
     * @access public
     */
    public function truncate(){
        $this->Aco->query('TRUNCATE acos;');
        $this->Aro->query('TRUNCATE aros;');
        $this->Group->query('TRUNCATE groups;');
        $this->Person->query('TRUNCATE people;');
        $this->flash('Truncation complete. Begining ACL based privledge set up...', '/first_run/root_acl');
    }

    /**
     * Build the initial ACOs table, create an ARO entry for
     * user "root" and gives him all permissions
     * @return void
     * @access public
     */
    public function root_acl()
    {

        $this->Session->delete('Auth');
        
        $controllers = $this->ControllerList->get();

        $this->Acl->Aco->create(array('alias' => 'root', 0, 0));
        $this->Acl->Aco->save();

        $this->Acl->Aro->create(array(
            'model' => 'User',
            'foreign_key' => '4e27efec-ece0-4a36-baaf-38384bb83359',
            'alias' => 'root', 0, 0));

        $this->Acl->Aro->save();

        foreach ($controllers as $key => $value) {
            foreach ($controllers[$key] as $action) {
                $this->Acl->Aco->create(array(
                    'parent_id' => 1,
                    'alias' => $key . '-' . $action, 0, 0
                ));
                $this->Acl->Aco->save();

                $this->Acl->allow('root', $key . '-' . $action, '*');
            }
        }
        
        $this->flash('ACL Root Setup Complete. Creating system users...', '/first_run/create_people');
    }

    /**
     * Creates the default system users
     * @return void
     * @access public
     */
    public function create_people(){

        $people =
        array(
            array(
            'Person'=>array(
                    'id'=>'4e24236d-6bd8-48bf-ac52-7cce4bb83359',
                    'email'=>NULL,
                    'username'=> 'system',
                    'password'=>NULL,
                    'salt'=>NULL,
                    'first_name'=>NULL,
                    'last_name'=>NULL,
                    'employee'=>0,
                    'object_type'=>'system',
                    'created'=>'2011-07-21 01:46:22',
                    'created_person_id'=>'4e24236d-6bd8-48bf-ac52-7cce4bb83359',
                    'modified'=>'2011-07-21 01:46:22',
                    'modified_person_id'=>'4e24236d-6bd8-48bf-ac52-7cce4bb83359',
                ),
             ),
             array(
                 'Person'=>array(
                    'id'=>'4e27efec-ece0-4a36-baaf-38384bb83359',
                    'email'=>NULL,
                    'username'=>'root',
                    'password'=>NULL,
                    'salt'=>NULL,
                    'first_name'=>NULL,
                    'last_name'=>NULL,
                    'employee'=>1,
                    'object_type'=>'system',
                    'created'=>'2011-07-21 01:46:22',
                    'created_person_id'=>'4e24236d-6bd8-48bf-ac52-7cce4bb83359',
                    'modified'=>'2011-07-21 01:46:22',
                    'modified_person_id'=>'4e24236d-6bd8-48bf-ac52-7cce4bb83359',)));

        $count = count($people);
        foreach($people as $person){
            $i=0;
            if($this->Person->save($person['Person'])){ 
                $i++;
                if($i == ($count - 1)){
                    $this->flash('System users created. Building default groups...', '/first_run/create_groups');
                }
            }else{
                $this->Person->query('TRUNCATE people;');
                $this->flash('Failed to create people, retrying...', '/first_run/create_people');
            }
        }
        
    }
    
    /**
     * Creates the systems default groups
     * @return void
     * @access public
     */
    public function create_groups(){
        $groups =
        array(
            array(
            'Group'=>array(
                    'id'=>'4e5fcfef-8e80-40bb-a72f-22424bb83359',
                    'name'=>'Basic User',
                    'alias'=> 'basic_user',
                    'object_type'=>'acl',
                    'created'=>'2011-09-01 01:40:24',
                    'created_person_id'=>'4e24236d-6bd8-48bf-ac52-7cce4bb83359',
                    'modified'=>'2011-09-01 01:40:24',
                    'modified_person_id'=>'4e24236d-6bd8-48bf-ac52-7cce4bb83359',
                ),
             ));
        $count = count($groups);
        foreach($groups as $group){
            $i=0;
            if($this->Group->save($group['Group'])){
                $i++;
                
                $this->Acl->Aco->create(array('parent_id'=>1, 'alias' => $group['Group']['alias'] . '-group', 0, 0));
                $this->Acl->Aco->save();

                $this->Acl->Aro->create(array(
                    'model' => 'Group',
                    'foreign_key' => $group['Group']['id'],
                    'alias' => $group['Group']['alias'], 0, 0));

                $this->Acl->Aro->save();
                
                if($i == ($count)){
                    $this->Session->setFlash(
                            __('Auto setup complete; finish the root configuration'), 'success');
                    $this->flash('Default groups created. Configuring root...', '/first_run/configure_root');
                }
            }else{
                $this->Group->query('TRUNCATE groups;');
                $this->flash('Failed to create people, retrying...', '/first_run/create_groups');
            }
        }         
    }
    
    /**
     * Sets up the root user
     * @return void
     * @access public
     */
    public function configure_root(){
        if(!empty($this->data)){
            if($this->User->createUser($this->data['User'])){
                $this->Session->setFlash(__('Setup complete, you may now try your root login'), 'success');
                $this->flash('Setup complete, you may now try your root login', '/users/login');
            }
        }
    }

}
