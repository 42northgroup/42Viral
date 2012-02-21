<?php
/**
 * Tag model
 *
 * @package tags
 * @subpackage tags.models
 */
class AuditDelta extends AppModel {

    /**
     * Name
     *
     * @var string $name
     */
    public $name = 'AuditDelta';
    /**
     * 
     * @var array
     * @access public
     */
    public $belongsTo = array(
        'Audit' => array(
            'className' => 'Audit',
            'foreignKey' => 'audit_id',
            'dependent' => true
        )
    );
}