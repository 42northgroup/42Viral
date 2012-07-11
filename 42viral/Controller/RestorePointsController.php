<?php
/* Provides control logic for restoring content states using an audit log
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
 * @package       42viral\RestorePoints
 */

App::uses('AppController', 'Controller');
/**
 * Provides control logic for restoring content states using an audit log
 *
 * @author James Rohacik <james.rohacik@42northgroup.com>
 */
 class RestorePointsController extends AppController
{

   /**
     * Controller name
     * @var string
     * @access public
     */
    public $name = 'RestorePoints';


    /**
     * Model this controller uses
     * @var array
     * @access public
     */
    public $uses = array(
        'RestorePoint'
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
     * Lists restore points that can be made to an object.
     *
     * @access public
     * @param string $id - ID of the object to list restore points.
     */
    function listing ($model, $id) {
        $restorePoints = $this->RestorePoint->find('all', array(
            'conditions' => array(
                'RestorePoint.entity_id' => $id
            ),
            'contain' => array(
                'AuditDelta'
            )
        ));

        if ($restorePoints === false) {
            $this->Session->setFlash(__('There are no restore points available for this object.'), 'error');
        }
        else {
            $this->set('restore_points', $restorePoints);
            $this->set('restore_model', $model);
        }

        $this->set('title_for_layout', 'Restore Points');
    }

    /**
     * Compares the current state of an object to a user selected restore point.
     *
     * @access public
     * @param string $id - ID of the restore point to compare to the current object state.
     */
    function overview ($id) {
        $restorePoint = $this->RestorePoint->getRestorePoint($id);

        if ($restorePoint === false) {
            $this->Session->setFlash(__('Could not access restore point.'), 'error');
        }
        else {
            $this->set('restore_point', $restorePoint);
            $this->set('restore_model', $restorePoint['RestorePoint']['model']);
        }

        $this->set('title_for_layout', 'Restore Point Overview');
    }

    /**
     * Restores an object to its user selected restore point.
     *
     * @access public
     * @param string $id - ID of the restore point to restore the object.
     */
    function restore ($id) {
        $restorePoint = $this->RestorePoint->getRestorePoint($id);

        if ($restorePoint === false) {
            $this->Session->setFlash(__('Could not access restore point for restoration.'), 'error');
        }
        else {
            $restore = json_decode($restorePoint['RestorePoint']['json_object']);
            $model = $restorePoint['RestorePoint']['model'];
            $this->loadModel($model);
            $restoreSave = array(
                'id' => $restorePoint['RestorePoint']['entity_id'],
                'title' => $restore->{$model}->title,
                'body' => $restore->{$model}->body
            );

            if ($this->{$model}->save($restoreSave)) {
                $this->set('restore_point', $restorePoint);
                $this->set('restore_model', $restorePoint['RestorePoint']['model']);
                $this->Session->setFlash(__('Object successfully restored'), 'success');
                $this->redirect($this->referer());
            }
        }

        $this->set('title_for_layout', 'Restore Point Restoration');
    }

}
    ?>