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

App::uses('Scrub', 'Lib');
App::uses('Sanitize', 'Utility');
/**
 * SeoBehavior test class.
 * @package Plugin.ContentFilter
 * @subpackage Plugin.ContentFilter.Test.Case.Lib
 * @author Jason D Snider <root@jasonsnider.com>
 */
class ScrubTest extends CakeTestCase {
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


  /**
   * Simulates the creation of a slug based on the column of a given record
   *
   * @return void
   * @access public
   */
  public function testHtmlMediaAllowsYouttubeViaHtml5() {

    $input = '<iframe title="YouTube video player" width="480" height="390" src="https://www.youtube.com/embed/RVtEQxH7PWA" frameborder="0" allowfullscreen></iframe>';
    $expected = '<p><iframe title="YouTube video player" width="480" height="390" src="https://www.youtube.com/embed/RVtEQxH7PWA" frameborder="0"></iframe></p>';

    $scrubed = Scrub::htmlMedia($input);

    $this->assertEquals($scrubed, $expected);
  }

  /**
   * Simulates the creation of a slug based on the column of a given record
   *
   * @return void
   * @access public
   */
  public function testHtmlMediaDoesNotStripEmptyIFrames() {

    $input = '<iframe></iframe>';
    $expected = '<p><iframe></iframe></p>';

    $scrubed = Scrub::htmlMedia($input);

    $this->assertEquals($scrubed, $expected);
  }

  /**
   * Tests the repair of broken tags
   *
   * @return void
   * @access public
   */
  public function testHtmlMediaFixesBrokenTags() {

    $input = '<p></p';
    $expected = '<p></p>';

    $scrubed = Scrub::htmlMedia($input);

    $this->assertEquals($scrubed, $expected);
  }

}