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
                    'Upload.model'=>$model,
                    'Upload.model_id'=>$modelId,
                ),
                'fields'=>array(
                    'Upload.uri',
                    'Upload.thumbnail_image_uri',
                    'Upload.object_type'
                ),
                'contain'=>array()
            )
        );

        $this->set('uploads', $uploads);
        $this->set('title_for_layout', __('Uploads'));
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
}