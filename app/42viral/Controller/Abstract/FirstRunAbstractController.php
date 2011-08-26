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
    public $uses = array('Aco', 'AclGroup', 'Aro', 'Person', 'User');


    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->auth(array('*'));
    }

    /**
     * The starting pont to the first run wizard
     */
    public function index(){
        $this->redirect('/first_run/build_initial_acl');
    }

    /**
     * Build the initial ACOs table, create an ARO entry for
     * user "root" and gives him all permissions
     *
     * @author Lyubomir R Dimov <lrdimov@yahoo.com>
     */
    public function build_initial_acl()
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

        $this->redirect('/first_run/load_initial_data');
    }

    /**
     * Creates the default system users
     */
    public function load_initial_data(){

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
                    'bio'=>'',
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
                    'bio'=>'',
                    'object_type'=>'system',
                    'created'=>'2011-07-21 01:46:22',
                    'created_person_id'=>'4e24236d-6bd8-48bf-ac52-7cce4bb83359',
                    'modified'=>'2011-07-21 01:46:22',
                    'modified_person_id'=>'4e24236d-6bd8-48bf-ac52-7cce4bb83359',)));

        foreach($people as $person){
            if($this->Person->save($person['Person'])){

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
            $this->User->createUser($this->data['User']);
        }
    }

}
