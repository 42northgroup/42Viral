<?php

App::uses('AppController', 'Controller');

/**
 *
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
     */
    public function index(){
        $this->flash('Begining ACL based privledge set up...', '/first_run/root_acl');
    }

    /**
     * Build the initial ACOs table, create an ARO entry for
     * user "root" and gives him all permissions
     *
     * @author Lyubomir R Dimov <lrdimov@yahoo.com>
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
                $this->flash('Failed to create people, retrying...', '/first_run/create_people');
            }
        }
        
    }
    
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

        foreach($groups as $group){
            if($this->Group->save($group['Group'])){

            }else{
                die('Set up failed');
            }
        }
        $this->redirect('/first_run/create_root');
    }
    

    /**
     * Sets up the root user
     */
    public function create_root(){
        if(!empty($this->data)){
            if($this->User->createUser($this->data['User'])){
                $this->Session->setFlash(__('The root user is now ready') ,'success');
                $this->redirect('/users/login');
            }
        }
    }

}
