<?php
/**
 * PHP 5.3
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
 */

App::uses('Handy', 'Lib');
/**
 * Tests the functions inside of the Handy library
 * 
 * @author Jason D Snider <root@jasonsnider.com>
 */
class HandyTest extends CakeTestCase {
  /**
   * Fixtures associated with this test case
   *
   * @var array
   * @access public
   */
    public $fixtures = array();
  
  /**
   * Method executed before each test
   * 
   * @return void
   * @access public
   */
    public function startTest() {}
  
  /**
   * Method executed after each test
   * 
   * @return void
   * @access public
   */
    public function endTest() {
        ClassRegistry::flush();
    }
    
/*
 * Phone Number Tests
 * =============================================================
 */  
    
    /**
     * Tests the conversion of a standard 10 digit integer
     * 
     * @return void
     * @access public
     */
    public function testConvertATenDigitIntergerToAPhoneNumber() {

        $result = Handy::phoneNumber('0123456789');
        $expected = '<a href="tel:0123456789">(012) 345-6789</a>';
        $this->assertEquals($expected, $result);

    }
  
    /**
     * Tests the conversion of a preformatted phone number
     * 
     * @return void
     * @access public
     */
    public function testConvertPreformattedStringToAStandardPhoneNumber() {

        $result = Handy::phoneNumber('012.345.6789');
        $expected = '<a href="tel:0123456789">(012) 345-6789</a>';
        $this->assertEquals($expected, $result);

    }
    
    /**
     * Tests the conversion of an international number
     * 
     * @return void
     * @access public
     */
    public function testInternationalPhoneNumber() {

        $result = Handy::phoneNumber('012.345.6789', array('international'=>true));
        $expected = '<a href="tel:+10123456789">(012) 345-6789</a>';
        $this->assertEquals($expected, $result);

    }    
    
    
/*
 * Email Tests
 * =============================================================
 */    
    
    /**
     * Tests the conversion of an international number
     * 
     * @return void
     * @access public
     */
    public function testCreateMailtoLink() {

        $result = Handy::email('test@example.com');
        $expected = '<a href="mailto:test@example.com">test@example.com</a>';
        $this->assertEquals($expected, $result);

    }    
}