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
 class EmailAddressesController extends AppController
{

    /**
     * Models this controller uses
     * @var array
     * @access public
     */
    public $uses = array(
        'EmailAddress'
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

        //Retrieve and paginate all related email addressees
        $this->paginate = array(
            'conditions' => array(
                'EmailAddress.model'=>$model,
                'EmailAddress.model_id'=>$modelId
            ),
            'fields'=>array(
                'EmailAddress.id',
                'EmailAddress.label',
                'EmailAddress.email_address'
            ),
            'limit' => 10,
            'order'=>array('EmailAddress.label', 'EmailAddress.email_address')
        );

        $emailAddresses = $this->paginate('EmailAddress');

        $this->set('emailAddresses', $emailAddresses);
        $this->set('title_for_layout', __('Your Email Addresses'));
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
    		$this->EmailAddress->create();
    		if($this->EmailAddress->save($this->data)){
    			$this->Session->setFlash(__('A new address has been added to your profile'), 'success');
    			$this->redirect("/email_addresses/edit/{$this->EmailAddress->id}/");
    		}else{
    			$this->Session->setFlash(__('The email address could not be added'), 'error');
    		}
    	}

    	$this->set('listEmailAdressTypes', $this->EmailAddress->listEmailAddressTypes());

    	$this->set('model', $classifiedModel);
    	$this->set('modelId', $modelId);
    	$this->set('title_for_layout', __('Add as Email Address to Your Profile'));
    }

    /**
     * @access public
     * @param string $email
     */
    public function edit($emailAddressId){

        $buildDataArray = true;

        $this->_validRecord('EmailAddress', $emailAddressId);

        if(!empty($this->data)){

            if($this->EmailAddress->save($this->data)){
                $this->Session->setFlash(__('A new email has been updated to your profile'), 'success');
            }else{
                $this->Session->setFlash(__('The email could not be updated'), 'error');
                //If the data fails validation we do not want to loose the user submitted data
                $buildDataArray = false;
            }
        }

        if($buildDataArray){
            $this->data = $this->EmailAddress->find('first',
                array(
                    'conditions'=>array('EmailAddress.id'=>$emailAddressId),
                    'contain'=>array(),
                    'fields'=>array(
                        'EmailAddress.id',
                        'EmailAddress.email_address',
                        'EmailAddress.label',
                        'EmailAddress.type'
                    )
                )
            );
        }

        $this->set('listEmailAdressTypes', $this->EmailAddress->listEmailAddressTypes());
        $this->set('title_for_layout', __('Update an Email Address'));
    }

    /**
     * Removes an email
     *
     * @access public
     * @param $id ID of the email which we want ot delete
     * @param string $model Probably Person - used for an ownership integrity check
     * @param string $modelId - Probably a Person.id  - used for an ownership integrity check
     */
    public function delete($id, $model, $modelId){

        $this->_validAssociation($model, $modelId);

        if($this->EmailAddress->delete($id)){
            $this->Session->setFlash(__('Your email has been removed'), 'success');
            $this->redirect("/email_addresses/index/person/{$modelId}/");
        }else{
            $this->Session->setFlash(__('There was a problem removing the email address'), 'error');
            $this->redirect($this->referer());
        }

    }
}