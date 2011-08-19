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
     * Tests that <p></p> is applied to nl2br scenarios
     */
    public function testHTMLAutoParagraph(){
        $result = Scrub::html('Bob is cool');
        $expected = '<p>Bob is cool</p>';
        $this->assertEqual($result, $expected);
    }
    
    /**
     * Tests that <p></p> is applied to nl2br scenarios
     */
    public function testHTMLinkify(){
        $result = Scrub::html('http://www.42viral.org');
        $expected = '<p><a href="http://www.42viral.org">http://www.42viral.org</a></p>';
        $this->assertEqual($result, $expected);
    }    
     
    /**
     * Tests for the removal of jibberish
     */
    public function testRemoveEmpty(){
        $result = Scrub::html('<div><p>Test String</p><span></span><p>&nbsp;</p></div>');
        $expected = '<div><p>Test String</p></div>';
        $this->assertEqual($result, $expected);
    }       
    
    /**
     * @todo Test against ha.ckers.org xxs sheetsheet
     */
    public function testXXS(){

        return true;
    }
 
}
