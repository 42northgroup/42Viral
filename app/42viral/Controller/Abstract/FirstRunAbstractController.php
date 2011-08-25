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
    public $uses = array('Person', 'Aro', 'Aco', 'AclGroup');
    

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->auth(array('*'));
    }
    
    /**
     * @todo - Come up with some kind of run once logic
     */
    public function admin_build_initial_acl()
    {
       $controllers = $this->ControllerList->get();
       
       $this->Acl->Aco->create(array('alias'=>'root',0,0));
       $this->Acl->Aco->save();
       
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
    }
    

}
