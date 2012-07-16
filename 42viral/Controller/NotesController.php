<?php
/* Provides control logic for entering and editing notes
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
 * @package       42viral\Notes
 */

App::uses('AppController', 'Controller');
/**
 * Provides control logic for entering and editing notes.
 *
 * @author James Rohacik <james.rohacik@42northgroup.com>
 */
 class NotesController extends AppController
{

   /**
     * Controller name
     * @var string
     * @access public
     */
    public $name = 'Notes';


    /**
     * Model this controller uses
     * @var array
     * @access public
     */
    public $uses = array(
        'Note'
    );

    /**
     * Components
     * @var array
     * @access public
     */
    public $components = array();

    /**
     * Helpers
     *
     * @var array
     * @access public
     */
    public $helpers = array(
        'Html',
        'Session'
    );

    /**
     * beforeFilter
     * @access public
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->auth();
    }

    /**
     * Creates a note.
     *
     * @access public
     * @param $model string - model that the call to this method is coming from.
     * @param $model_id string - foreign key - ID of model record that has ownership of this note.
     */
    public function create($model, $modelId, $plugin = null) {

        $classifiedModel = $this->_validAssociation($model, $modelId);

        //if (isset($plugin)) {
        //
        //}

        if(!empty($this->data)) {
            if($this->Note->save($this->data)) {
                $this->Session->setFlash(__('Your note has been saved'), 'success');
                $this->redirect(strtolower("/{$classifiedModel}/{$model_id}"));
            }
            else {
                $this->Session->setFlash(__('There was a problem saving your note'), 'error');
            }
        }

        $this->set('model', $classifiedModel);
        $this->set('modelId', $modelId);

        $this->set('title_for_layout', __('Create a Note'));

    }

    /**
     * Edit a note.
     *
     * @access public
     * @param $id string - ID of the note to be edited.
     */
    public function edit($id) {

        if(!empty($this->data)) {
            if($this->Note->save($this->data)) {
                $this->Session->setFlash(__('Your note has been saved'), 'success');
                $this->redirect(strtolower("/{$classifiedModel}/{$model_id}"));
            }
            else {
                $this->Session->setFlash(__('There was a problem saving your note'), 'error');
            }
        }

        $note = $this->Note->find('first',
            array(
                'conditions' => array(
                    'created_person_id' => $this->Session->read('Auth.User.id')
                ),
                'fields' => array(
                    'Note.id',
                    'Note.model',
                    'Note.model_id',
                    'Note.note'
                ),
                'contain' => array()
            )
        );

        $this->set('note', $note);

        $this->set('title_for_layout', __('Edit a Note'));

    }

    /**
     * Deletes a note.
     *
     * @access public
     * @param $id string - ID of the note to be deleted.
     */
    public function delete($id){

        if($this->Note->delete($id)){
            $this->Session->setFlash(__('Your note has been deleted'), 'success');
        }
        else{
           $this->Session->setFlash(__('There was a problem deleting your note'), 'error');
        }

        $this->redirect($this->referer());

    }

}

?>