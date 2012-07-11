<?php
/**
 * Model for restore points.
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package 42viral\Content\Blog
 */

App::uses('AppModel', 'Model');

/**
 * Model for restore points.
 *
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral\Content\Blog
 */
class RestorePoint extends AppModel
{
    /**
     * The static name of the Audit class
     * @access public
     * @var string
     */
    public $name = 'RestorePoint';

    /**
     * Specifies the table to be used by the Audit model and its children
     * @access public
     * @var string
     */
    public $useTable = 'audits';

    /**
     * Defines the default set of behaivors for all audit restore points.
     * @access public
     * @var array
     */
    public $actsAs = array(
        'Scrubable'=>array(
            'Filters'=>array(
                'trim'=>'*',
                'htmlMedia'=>array('body'),
                'noHTML'=>array('id', 'title', 'description', 'keywords', 'canonical', 'syntax')
            )
        )

    );

    /**
     * Defines the has many relationships for the RestorePoint model
     * @access public
     * @var array
     */
    public $hasMany = array(
        'AuditDelta' => array(
            'className' => 'AuditDelta',
            'foreignKey' => 'audit_id',
            'dependent' => true
        )
    );

    /**
     * Defines the has one relationship for the RestorePoint model
     * @access public
     * @var array
     */
    public $belongsTo = array(
        'Content' => array(
            'className' => 'Content',
            'foreignKey' => 'entity_id',
            'dependent' => true
        )
    );

    /**
     * Defines validation
     * @var array
     * @access public
     */
    public $validate = array();

    /**
     * Returns the requested restore point for restoring an objects previous state.
     *
     * @access public
     * @param $id string - ID of the audit log entry.
     */
    public function getRestorePoint($id) {
        return $this->find('first', array(
            'conditions' => array(
                'RestorePoint.id' => $id
            ),
            'fields' => array(
                'RestorePoint.id',
                'RestorePoint.model',
            	'RestorePoint.entity_id',
                'RestorePoint.json_object'
            ),
            'contain' => array()
        ));
    }

}