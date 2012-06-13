<?php
/**
 * Provides controll logic for managing users
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
 * Provides controll logic for managing addresss
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral\Person\User\Profile
 */
 class AddressesController extends AppController
{

    /**
     * Models this controller uses
     * @var array
     * @access public
     */
    public $uses = array(
        'Address'
    );

    /**
     * Components
     * @var array
     * @access public
     */
    public $components = array();

    /**
     * Helpers
     * @var array
     * @access public
     */
    public $helpers = array();

    /**
     * beforeFilter
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();
        $this->auth();
    }

    /**
     * Associates a address profile to a 42Viral profile
     * @access public
     */
    public function create($model, $modelId){

    	$classifiedModel = Inflector::classify($model);

    	//Does the entitiy to which we want to attach the address exist? If not throw a 403 error.
    	$this->loadModel($classifiedModel);
    	$association = $this->$classifiedModel->find('first',
    		array(
    			'conditions'=>array(
    				"{$classifiedModel}.id"=>$modelId
    			),
    			'contain'=>array()
    			)
    		);

    	if(empty($association)){
			throw new forbiddenException('The requested association does not exist!');
    	}

        if(!empty($this->data)){

            if($this->Address->save($this->data)){
                $this->Session->setFlash(__('A new address has been added to your profile'), 'success');
            }else{
                $this->Session->setFlash(__('The address could not be added'), 'error');
            }
        }

        $this->set('model', $classifiedModel);
        $this->set('modelId', $modelId);
        $this->set('states', $this->Address->listStates('US'));
        $this->set('title_for_layout', __('Add a Social Network to Your Profile'));
    }

    /**
     *
     * @param string $addressId
     */
    public function edit($addressId){
        if(!empty($this->data)){

            if($this->Address->save($this->data)){
                $this->Session->setFlash(__('A new address has been updated to your profile'), 'success');
            }else{
                $this->Session->setFlash(__('The address could not be updated'), 'error');
            }
        }

        $this->data = $this->Address->find('first',
                array(
                    'conditions'=>array('Address.id'=>$addressId),
                    'contain'=>array()
                    )
                );

        $this->set('title_for_layout', __('Update an Address'));
    }

    /**
     *
     * @access public
     * @param string $personId
     */
    public function index($modelId){

        //If we found the target blog, retrive an paginate its' posts
        $this->paginate = array(
            'conditions' => array(
                'Address.model_id'=>$modelId
            ),
            'fields'=>array(
                'Address.id',
                'Address.line1',
                'Address.line2',
                'Address.city',
                'Address.state',
                'Address.zip',
                'Address.created',
                'Address.modified'
            ),
            'limit' => 10,
            'order'=>'Address.id ASC'
        );

        $addresses = $this->paginate('Address');

        $this->set('addresses', $addresses);
        $this->set('title_for_layout', __('Your Addresses'));
    }

    /**
     *
     * @access public
     * @param string $modelId
     */
    public function view($modelId){

    	//If we found the target blog, retrive an paginate its' posts
    	$addresses = $this->Address->find('first',
    		array(
    			'conditions' => array(
    				'Address.model_id'=>$modelId
    			),
    			'fields'=>array(
    				'Address.id',
    				'Address.line1',
    				'Address.line2',
    				'Address.city',
    				'Address.state',
   					'Address.zip',
   					'Address.created',
   					'Address.modified'
    			)
    		)
    	);

    	$this->set('addresses', $addresses);
    	$this->set('title_for_layout', __('Your Addresses'));
    }

    /**
     * Removes a address
     *
     * @access public
     * @param $id ID of the social_network which we want ot delete
     */
    public function delete($id){

        if($this->Address->delete($id)){
            $this->Session->setFlash(__('Your address has been removed'), 'success');
            $this->redirect($this->referer());
        }else{
           $this->Session->setFlash(__('There was a problem removing the address'), 'error');
           $this->redirect($this->referer());
        }

    }
}