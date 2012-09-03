<?php
/**
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
App::uses('ProfileUtility', 'Lib');
/**
 * Provides controll logic for managing social networks
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral\Person\User\Profile
 */
 class SocialNetworksController extends AppController
{

    /**
     * Models this controller uses
     * @var array
     * @access public
     */
    public $uses = array(
        'Person',
        'SocialNetwork'
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
     * Associates a social network profile to a 42Viral profile
     * @access public
     * @param string $model
     * @param string $modelId
     */
    public function create($model, $modelId){

        $classifiedModel = $this->_validAssociation($model, $modelId);

        if(!empty($this->data)){

            if($this->SocialNetwork->save($this->data)){
                $this->Session->setFlash(__('A new social network has been added to your profile'), 'success');
            }else{
                $this->Session->setFlash(__('The social network could not be added'), 'error');
            }
        }

        $this->set('model', $classifiedModel);
        $this->set('modelId', $modelId);
        $this->set('networks', $this->SocialNetwork->listSocialNetworks());
        $this->set('title_for_layout', __('Add a Social Network to Your Profile'));
    }

    /**
     * @access public
     * @param string $socialNetworkId
     */
    public function edit($socialNetworkId){

        $this->_validRecord('SocialNetwork', $socialNetworkId);

        if(!empty($this->data)){

            if($this->SocialNetwork->save($this->data)){
                $this->Session->setFlash(__('A new social network has been updated to your profile'), 'success');
            }else{
                $this->Session->setFlash(__('The social network could not be updated'), 'error');
            }
        }

        $this->data = $this->SocialNetwork->find('first',
                array(
                    'conditions'=>array('SocialNetwork.id'=>$socialNetworkId),
                    'contain'=>array()
                    )
                );

        $this->set('networks', $this->SocialNetwork->listSocialNetworks());
        $this->set('title_for_layout', __('Update a Social Network'));
    }

    /**
     *
     * @access public
     * @param string $model
     * @param string $modelId
     */
    public function index($model, $modelId){

        $classifiedModel = $this->_validAssociation($model, $modelId);

        //If we found the target blog, retrive an paginate its' posts
        $this->paginate = array(
            'conditions' => array(
                'SocialNetwork.model'=>$classifiedModel,
                'SocialNetwork.model_id'=>$modelId
            ),
            'fields'=>array(
                'SocialNetwork.id',
                'SocialNetwork.created',
                'SocialNetwork.modified',
                'SocialNetwork.network',
                'SocialNetwork.profile_url'
            ),
            'limit' => 10,
            'order'=>'SocialNetwork.network ASC'
        );

        $socialNetworks = $this->paginate('SocialNetwork');

        $person = $this->Person->find(
            'first',
            array(
                'conditions'=>array(
                    'Person.id'=>$modelId
                ),
                'fields'=>array(
                    'Person.username',
                    'Person.name'
                )
            )
        );

        $this->set('person', $person);

        $this->set('mine', ($person['Person']['id']==$this->Session->read('Auth.User.id')?true:false));

        $this->set('socialNetworks', $socialNetworks);
        $this->set('title_for_layout', ProfileUtility::name($person['Person']). "'s Social Networks");
    }

    /**
     * Removes a social network
     *
     * @access public
     * @param $id ID of the social_network which we want ot delete
     */
    public function delete($id){

        if($this->SocialNetwork->delete($id)){
            $this->Session->setFlash(__('Your social network has been removed'), 'success');
            $this->redirect($this->referer());
        }else{
           $this->Session->setFlash(__('There was a problem removing the social network'), 'error');
           $this->redirect($this->referer());
        }

    }
}