<?php

App::import( 'Core', array( 'AppModel', 'Model' ) );

/**
 * Article class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model
 */
class Article extends CakeTestModel {
  /**
   * name property
   *
   * @var string
   * @access public
   */
  public $name = 'Article';
  
  /**
   * actAs property - Behaviors
   *
   * @var array
   * @access public
   */  
  public $actsAs = array(
    'Seo'
  );
  
}

/**
 * SeoBehavior test class.
 */
class SeoBehaviorTest extends CakeTestCase {
  /**
   * Fixtures associated with this test case
   *
   * @var array
   * @access public
   */
    public $fixtures = array('article');
  
  /**
   * Method executed before each test
   *
   * @access public
   */
    public function startTest() {
        $this->Article = ClassRegistry::init('Article');
    }
  
  /**
   * Method executed after each test
   *
   * @access public
   */
    public function endTest() {
        unset($this->Article);
        ClassRegistry::flush();
    }
  
  /**
   * Test the action of creating a new record.
   *
   * @todo  Test HABTM save
   */
  public function testCreate() {
      
    $new_article = array(
      'Article' => array(
        'created_person_id'   => String::uuid(),
        'title'     => 'First Test Article', 
      ),
    );
    
    $this->Article->save($new_article);
    $article = $this->Article->find('first', 
            array('conditions'=>array('Article.id'=>$this->Article->getLastInsertId())));
    pr($article);
    die();
    
    # Verify the audit record
    $this->assertEqual( 1, $article['Article']['created_person_id'] );
    $this->assertEqual( 'First Test Article', $article['Article']['title'] );
    $this->assertEqual( 'N', $article['Article']['published'] );
    
    #Verify that no delta record was created.
    $this->assertTrue( empty( $deltas ) );
  }

}
