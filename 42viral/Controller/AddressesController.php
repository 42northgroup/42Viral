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
     * @param string $model
     * @param string $modelId
     */
    public function create($model, $modelId){

    	$classifiedModel = $this->_validAssociation($model, $modelId);

        if(!empty($this->data)){
        	$this->Address->create();
            if($this->Address->save($this->data)){
                $this->Session->setFlash(__('A new address has been added to your profile'), 'success');
                $this->redirect("/addresses/edit/{$this->Address->id}/");
            }else{
                $this->Session->setFlash(__('The address could not be added'), 'error');
            }
        }

        $this->set('model', $classifiedModel);
        $this->set('modelId', $modelId);
        $this->set('states', $this->Address->listStates('US'));
        $this->set('addressTypes', $this->Address->listAddressTypes());
        $this->set('title_for_layout', __('Add an Address to Your Profile'));
    }

    /**
     * @access public
     * @param string $addressId
     */
    public function edit($addressId){

    	$this->_validRecord('Address', $addressId);

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

        $this->set('states', $this->Address->listStates('US'));
        $this->set('addressTypes', $this->Address->listAddressTypes());
        $this->set('title_for_layout', __('Update an Address'));
    }

    /**
     *
     * @access public
     * @param string $model
     * @param string $modelId
     */
    public function index($model, $modelId){

    	$classifiedModel = Inflector::classify($model);

        //If we found the target blog, retrive an paginate its' posts
        $this->paginate = array(
            'conditions' => array(
            	'Address.model'=>$model,
                'Address.model_id'=>$modelId
            ),
            'fields'=>array(
                'Address.id',
            	'Address.label',
            	'Address.type',
                'Address.line1',
                'Address.line2',
                'Address.city',
                'Address.state',
                'Address.zip'
            ),
            'limit' => 10,
            'order'=>'Address.id ASC'
        );

        $addresses = $this->paginate('Address');

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