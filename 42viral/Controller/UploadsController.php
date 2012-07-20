<?php
/**
 * Provides controll logic for managing user profile actions
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
 * @package       42viral\Person\User\Profile
 */

App::uses('AppController', 'Controller');
App::uses('ProfileUtil', 'Lib');
/**
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral\Uploads
 */
 class UploadsController extends AppController {

    /**
     * Controller name
     * @var string
     * @access public
     */
    public $name = 'Uploads';

    /**
     * Models this controller uses
     * @var array
     * @access public
     */
    public $uses = array(
        'Upload'
    );

    /**
     * beforeFilter
     *
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->auth(array());
    }

    /**
     * Provides an index action for displaying all uploads tied to an entity
     * @access public
     * @param string $model
     * @param string $modelId
     */
    public function index($model, $modelId)
    {
        $classifiedModel = $this->_validAssociation($model, $modelId);

        $uploads = $this->Upload->find(
            'all',
            array(
                'conditions'=>array(
                    'Upload.model'=>$classifiedModel,
                    'Upload.model_id'=>$modelId,
                ),
                'fields'=>array(
                    'Upload.uri',
                    'Upload.thumbnail_image_uri',
                    'Upload.object_type',
                    'Upload.id',
                    'Upload.model',
                    'Upload.model_id',
                    'Upload.avatar'
                ),
                'contain'=>array()
            )
        );

        $this->set('uploads', $uploads);
        $this->_autoPageTitle("'s Uploads", $model, $modelId);

    }

    /**
     * Provides an action for uploading files
     * @access public
     * @param string $model
     * @param string $modelId
     */
    public function create($model, $modelId)
    {
        $classifiedModel = $this->_validAssociation($model, $modelId);

        if(!empty($this->data)){
            if($this->Upload->process($this->data)){
                if($this->data['Upload']['avatar'] == 1){
                    $this->Upload->updateAll(
                            array(
                                'Upload.avatar'=>0
                            ),
                            array(
                                'Upload.avatar'=>1,
                                "Upload.id NOT LIKE '{$this->Upload->id}'",
                                "Upload.model LIKE '{$model}'",
                                "Upload.model_id LIKE '{$modelId}'"
                            )
                        );
                }

                $this->Session->setFlash(__('The file has been uploaded'), 'success');
                $this->redirect("/uploads/index/{$model}/{$modelId}");
            }else{
                $this->Session->setFlash(__('The file could not be uploaded'), 'error');
            }
        }

        $this->set('model', $classifiedModel);
        $this->set('modelId', $modelId);
        $this->set('title_for_layout', __('Upload a File'));
    }

    /**
     * Sets an image as an avatar, makes the avatar flag 0 for all other file related to that model, modelId
     *
     * @access public
     * @param string $model
     * @param string $modelId
     * @param string $uploadId
     */
    public function make_avatar($model, $modelId, $uploadId)
    {
        $uploads = $this->Upload->find('all', array(
            'conditions' => array(
                'Upload.model' => $model,
                'Upload.model_id' => $modelId
            )
        ));

        foreach($uploads as &$upload){
            if($upload['Upload']['id'] == $uploadId){
                $upload['Upload']['avatar'] = 1;
            }else{
                $upload['Upload']['avatar'] = 0;
            }
        }

        if($this->Upload->saveAll($uploads)){
            $this->Session->setFlash(_('Your avatar has been set'), 'success');
        }else{
            $this->Session->setFlash(_('There was a problem, we could not set you avatar'), 'error');
        }

        $this->redirect($this->referer());
    }
}