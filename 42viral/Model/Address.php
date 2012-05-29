<?php
/**
 * Mangages the address objects
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
 * @package 42viral\Address
 */

App::uses('AppModel', 'Model');
/**
 * Mangages the address objects
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @package 42viral\Address
 */
class Address extends AppModel
{
    /**
     * The statis name of the address object
     * @access public
     * @var string
     */
    public $name = 'Address';
    
    /**
     * Specifies the table to be used by the address model
     * @access public
     * @var string
     */
    public $useTable = 'addresses';
    
    /**
     * Specifies the behaviors inoked by the address object
     * @access public
     * @var array
     */
    public $actsAs = array(
        'AuditLog.Auditable',
        'Log'
    );
    
    /**
     * Specifies the validation rules for the address model
     * @access public
     * @var array
     */
    public $validate = array(
        /*
        'zip' => array(
            'rule'    => array('postal', null, 'us'),
            'message' => 'Invalid Zip Code'
        )
        */
    );

    /**
     * Initialisation for all new instances of Address
     * @access public
     * @param mixed $id Set this ID for this model on startup, can also be an array of options, see above.
     * @param string $table Name of database table to use.
     * @param string $ds DataSource connection name.
     *
     */
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