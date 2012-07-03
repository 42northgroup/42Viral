<?php
/**
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2012, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package Plugin\ResumeWizard
 */

App::uses('ResumesAppController', 'ResumeWizard.Controller');
/**
 *
 * @author Jason D Snider <jason.snider@42northgroup.com>
 * @package Plugin\ResumeWizard
 */
class ResumesController extends ResumesAppController {

    /**
     * Define this controllers model access
     *
     * @var array
     * @access public
     */
    public $uses = array(
        'Person',
        'ResumeWizard.Resume'
    );

    /**
     * Helpers
     * @var array
     * @access public
     */
    public $helpers = array();

    /**
     * Components
     * @access public
     * @var array
     */
    public $components = array();

    /**
     * beforeFilter
     * @access public
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->auth(array('*'));
    }

    /**
     *
     * @param string $username the username for any system use
     */
    public function index() {

    }

    /**
     *
     * @param string $username the username for any system use
     */
    public function view($id) {

        $resume = $this->Resume->find(
            'first',
            array(
                'conditions'=>array(
                    'Resume.id'=>$id
                ),
                'contain'=>array(
                    'Person'=>array(
                        'fields'=>array(
                            'Person.id',
                            'Person.name'
                        )
                    ),
                    'ResumeEmailAddress'=>array(
                        'fields'=>array(
                            'ResumeEmailAddress.id',
                        )
                    )
                )
            )
        );

        $this->set('resume', $resume);
    }

    public function create($model, $modelId){

        $classifiedModel = $this->_validAssociation($model, $modelId);

        if(!empty($this->data)){
            if($this->Resume->save($this->data)){
                $this->Session->setFlash(__('Your resume has been created.'), 'success');
            }
        }

        $this->set('model', $classifiedModel);
        $this->set('modelId', $modelId);
    }
}
