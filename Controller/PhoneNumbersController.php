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
 class PhoneNumbersController extends AppController
{

    /**
     * Models this controller uses
     * @var array
     * @access public
     */
    public $uses = array(
        'PhoneNumber'
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

    public function index($model, $modelId){
        $classifiedModel = $this->_validAssociation($model, $modelId);
        //If we found the target blog, retrive an paginate its' posts
        $this->paginate = array(
            'conditions' => array(
                'PhoneNumber.model'=>$model,
                'PhoneNumber.model_id'=>$modelId
            ),
            'fields'=>array(
                'PhoneNumber.access',
                'PhoneNumber.id',
                'PhoneNumber.label',
                'PhoneNumber.phone_number',
                'PhoneNumber.type'
            ),
            'limit' => 10,
            'order'=>array('PhoneNumber.label', 'PhoneNumber.phone_number')
        );

        $phoneNumbers = $this->paginate('PhoneNumber');

        $this->set('phoneNumbers', $phoneNumbers);
        $this->set('title_for_layout', __('Your Phone Number'));
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
    		$this->PhoneNumber->create();
    		if($this->PhoneNumber->save($this->data)){
    			$this->Session->setFlash(__('A new phone number has been added to your profile'), 'success');
    			$this->redirect("/phone_numbers/edit/{$this->PhoneNumber->id}/");
    		}else{
    			$this->Session->setFlash(__('The phone number could not be added'), 'error');
    		}
    	}

    	$this->set('listPhoneNumberTypes', $this->PhoneNumber->listPhoneNumberTypes());
    	$this->set('listAccessTypes', $this->PhoneNumber->listAccessTypes());
    	$this->set('model', $classifiedModel);
    	$this->set('modelId', $modelId);

    	$this->set('title_for_layout', __('Add Phone Number to Your Profile'));
    }

    /**
     * @access public
     * @param string $phoneNumber
     */
    public function edit($phoneNumberId){
        $buildDataArray = true;
        $this->_validRecord('PhoneNumber', $phoneNumberId);

        if(!empty($this->data)){

            if($this->PhoneNumber->save($this->data)){
                $this->Session->setFlash(__('A new phone number has been updated to your profile'), 'success');
            }else{
                $this->Session->setFlash(__('The phone number could not be updated'), 'error');
                $buildDataArray = false;
            }
        }

        //Should we requery the data or use the user submitted data?
        if($buildDataArray){
            $this->data = $this->PhoneNumber->find('first',
                array(
                    'conditions'=>array('PhoneNumber.id'=>$phoneNumberId),
                    'contain'=>array(),
                    'fields'=>array(
                        'PhoneNumber.access',
                        'PhoneNumber.id',
                        'PhoneNumber.label',
                        'PhoneNumber.phone_number',
                        'PhoneNumber.type'
                    )
                )
            );
        }

        $this->set('listPhoneNumberTypes', $this->PhoneNumber->listPhoneNumberTypes());
        $this->set('listAccessTypes', $this->PhoneNumber->listAccessTypes());
        $this->set('title_for_layout', __('Update a Phone Number'));
    }

    /**
     * Removes a phone number
     *
     * @access public
     * @param $id ID of the phone number which we want ot delete
     * @param string $model Probably Person - used for an ownership integrity check
     * @param string $modelId - Probably a Person.id  - used for an ownership integrity check
     */
    public function delete($id, $model, $modelId){

        $this->_validAssociation($model, $modelId);

        if($this->PhoneNumber->delete($id)){
            $this->Session->setFlash(__('Your phone number has been removed'), 'success');
            $this->redirect("/phone_numbers/index/person/{$modelId}/");
        }else{
            $this->Session->setFlash(__('There was a problem removing the phone number'), 'error');
            $this->redirect($this->referer());
        }

    }
}