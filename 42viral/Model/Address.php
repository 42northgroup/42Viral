<?php
/**
 * PHP 5.3
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
 */

App::uses('AppModel', 'Model');

/**
 * Mangages the address objects
 *
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 */
class Address extends AppModel
{
    public $name = 'Address';
    
    public $useTable = 'addresses';
    
    /**
     * Behaviors
     * @var array
     * @access public
     */
    public $actsAs = array(
        'AuditLog.Auditable',
        'Log'
    );
    
    /**
     *
     * @var array
     * @access public
     */
    public $validate = array(
        'zip' => array(
            'rule'    => array('postal', null, 'us'),
            'message' => 'Invalid Zip Code'
        )
    );
    
    public $belongsTo = array();
    
    public function __construct($id=false, $table=null, $ds=null) {
        parent::__construct($id, $table, $ds);
        $this->virtualFields = array(
            '_us_full_address' => "CONCAT(
                `{$this->alias}`.`line1`, ' ',
                `{$this->alias}`.`line2`, ' ',
                `{$this->alias}`.`city`, ', ',
                `{$this->alias}`.`state`, ' ',
                `{$this->alias}`.`zip`
            )"
        );
    }


}