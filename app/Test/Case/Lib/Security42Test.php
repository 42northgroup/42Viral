<?php
App::uses('Sec', 'Lib');

class SecTestCase extends CakeTestCase {
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
     * @author Jason D Snider <jason.snider@42viral.org>
     * @access public
     */
    public function testMakeSalt() {
        
        //Since the return value is random, the only thing we have to test agaisnt it being an SHA512 hash.
        //all we have to go on for that is strlen()
        $result = strlen(Sec::makeSalt());

        $expected = 128;

        $this->assertEqual($result, $expected);
    } 
    
   /**
     * @author Jason D Snider <jason.snider@42viral.org>
     * @access public
     */    
    public function testHashPassword(){
        
        $salt = '345e3d73dbbb6fea3dbd4019d17f3ec16a7f88c258e49c8549d71e10c15fffbc616057e483162a21949644d18d10139e9531' 
            . '3b44ac571052cc0474b59a9540dd';
        
        $result = Sec::hashPassword('aBC%123#', $salt);
        
        $expected = '90a029acb50a9b9651a05336aef8bf5cbb4acda6415ee7a7d0d6020ad760eee2e5bf4440470aaff93f4611b20da5cb317'
            . 'ab248ac150e9a0acca46094a2bdaa60';
        
        $this->assertEqual($result, $expected);
    }
    
}
