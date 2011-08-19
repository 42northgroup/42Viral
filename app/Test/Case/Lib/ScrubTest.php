<?php
App::uses('Scrub', 'Lib');

class ScrubTestCase extends CakeTestCase {
    /**
     * If we have any fitures, call them here
     * @var array
     */
    var $fixtures = array();
    
    /**
     * 
     * @access public
     */
    public function __construct() {
        parent::__construct();
       
    }
    
    /**
     * @todo Test against ha.ckers.org xxs sheetsheet
     */
    public function testXXS(){

        return true;
    }
 
}
