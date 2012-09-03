<?php
/**
 * Copyright 2012, Jason D Snider (https://jasonsnider.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, Jason D Snider (https://jasonsnider.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link https://jasonsnider.com
 */

App::uses('Sec', 'Lib');
/**
 * SeoBehavior test class.
 * @package Plugin.ContentFilter
 * @subpackage Plugin.ContentFilter.Test.Case.Lib
 * @author Jason D Snider <root@jasonsnider.com>
 */
class SecTest extends CakeTestCase {

    /**
     * Provies a static salt value for testing
     * @var string
     * @access public
     */
    public $salt = '8hxUtA3NoSfz3ef36aW6LcIGoPa3ophwGPrbquYQneqrsFvyQrEBDoi3et6CTnaAdCMD7KuuYVXrBs1rVG4z5mCjRIXK67kjK6YSRsnQokh0OjsI0wi5UVpLDmvKuQ4f';
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

    public function testPasswordHash() {
        $hash = Sec::hashPassword('password', $this->salt);
        $expected = '5e4f1e66ae7bdeb976ceed8ea597ff676ef0f0c04b513e0d11760e01090a9ff4e532867d135354af38d24ea963e33f4c6dce75f93db493f380baed52e7a9cf6d';
        $this->assertEquals($hash, $expected);
    }

    /**
     * The result of makeSalt() MUST NOT ever yeild the same results twice
     *
     * @return void
     * @access public
     */
    public function testMakeSaltAmbiguity() {
      $hash1 = Sec::makeSalt();
      $hash2 = Sec::makeSalt();
      $this->assertNotEqual($hash1, $hash2);
    }

}