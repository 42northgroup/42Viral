<?php

App::uses('AppModel', 'Model');

/**
 * Mangages the address objects
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
abstract class AddressAbstract extends AppModel
{
    public $name = 'Address';

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