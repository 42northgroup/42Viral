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
 class ContactDetailsController extends AppController
{

    /**
     * Models this controller uses
     * @var array
     * @access public
     */
    public $uses = array(
        'ContactDetail'
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
        $this->auth('*');
    }

    public function index($model, $modelId){
        $classifiedModel = $this->_validAssociation($model, $modelId);
        //If we found the target blog, retrive an paginate its' posts
        $this->paginate = array(
            'conditions' => array(
                'ContactDetail.model'=>$model,
                'ContactDetail.model_id'=>$modelId
            ),
            'fields'=>array(
                'ContactDetail.id',
                'ContactDetail.label',
                'ContactDetail.type',
                'ContactDetail.value'
            ),
            'limit' => 10,
            'order'=>array('ContactDetail.type', 'ContactDetail.label', 'ContactDetail.value')
        );

        $contactDetails = $this->paginate('ContactDetail');

        $this->set('contactDetails', $contactDetails);
        $this->set('title_for_layout', __('Your Contact Details'));
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
    		$this->ContactDetail->create();
    		if($this->ContactDetail->save($this->data)){
    			$this->Session->setFlash(__('A new address has been added to your profile'), 'success');
    			$this->redirect("/contact_details/edit/{$this->ContactDetail->id}/");
    		}else{
    			$this->Session->setFlash(__('The contact detail could not be added'), 'error');
    		}
    	}

    	$this->set('model', $classifiedModel);
    	$this->set('modelId', $modelId);
    	$this->set('types', $this->ContactDetail->listTypes());
    	$this->set('title_for_layout', __('Add Contact Details to Your Profile'));
    }

    /**
     * @access public
     * @param string $contactDetail
     */
    public function edit($contactDetailId){

        $this->_validRecord('ContactDetail', $contactDetailId);

        if(!empty($this->data)){

            if($this->ContactDetail->save($this->data)){
                $this->Session->setFlash(__('A new contact detail has been updated to your profile'), 'success');
            }else{
                $this->Session->setFlash(__('The contact detail could not be updated'), 'error');
            }
        }

        $this->data = $this->ContactDetail->find('first',
            array(
                'conditions'=>array('ContactDetail.id'=>$contactDetailId),
                'contain'=>array(),
                'fields'=>array(
                    'ContactDetail.id',
                    'ContactDetail.label',
                    'ContactDetail.value'
                )
            )
        );

        $this->set('types', $this->ContactDetail->listTypes());
        $this->set('title_for_layout', __('Update a Contact Detail'));
    }

    /**
     * Removes a contact detail
     *
     * @access public
     * @param $id ID of the contact detail which we want ot delete
     * @param string $model Probably Person - used for an ownership integrity check
     * @param string $modelId - Probably a Person.id  - used for an ownership integrity check
     */
    public function delete($id, $model, $modelId){

        $this->_validAssociation($model, $modelId);

        if($this->ContactDetail->delete($id)){
            $this->Session->setFlash(__('Your contact detail has been removed'), 'success');
            $this->redirect("/contact_details/index/person/{$modelId}/");
        }else{
            $this->Session->setFlash(__('There was a problem removing the contact detail'), 'error');
            $this->redirect($this->referer());
        }

    }
}