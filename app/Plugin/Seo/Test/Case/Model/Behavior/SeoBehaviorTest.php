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

App::uses('AppModel', 'Model');
/**
 * GenericContent class
 * @author Jason D Snider <root@jasonsnider.com>
 */
class GenericContent extends CakeTestModel {
  /**
   * name property
   *
   * @var string
   * @access public
   */
  public $name = 'GenericContent';
  
  /**
   * actAs property - Behaviors
   *
   * @var array
   * @access public
   */  
  public $actsAs = array(
    'Seo.Seo'
  );

}

/**
 * Article class
 * @author Jason D Snider <root@jasonsnider.com>
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
    'Seo.Seo'=>array(
        'convert'=>'name'
    )
  );

}

/**
 * SeoBehavior test class.
 * @author Jason D Snider <root@jasonsnider.com>
 */
class SeoBehaviorTest extends CakeTestCase {
  /**
   * Fixtures associated with this test case
   *
   * @var array
   * @access public
   */
    public $fixtures = array(
        'plugin.seo.GenericContent', 
        'plugin.seo.Article'
    );
  
  /**
   * Method executed before each test
   * 
   * @return void
   * @access public
   */
    public function startTest() {
        $this->GenericContent = ClassRegistry::init('GenericContent');
        $this->Article = ClassRegistry::init('Article');
    }
  
  /**
   * Method executed after each test
   * 
   * @return void
   * @access public
   */
    public function endTest() {
        unset($this->GenericContent);
        unset($this->Article);
        ClassRegistry::flush();
    }

  
  /**
   * Simulates the creation of a slug based on the column of a given record
   * 
   * @return void
   * @access public
   */
  public function testCreateSlugFromTitle() {
      
    $createGenericContent = array(
      'GenericContent' => array(
        'title' => 'Running a Test', 
      ),
    );

    $this->GenericContent->create();
    $this->GenericContent->save($createGenericContent);

    
    $result = $this->GenericContent->find('first', 
            array(
                'conditions'=>array('GenericContent.id'=>$this->GenericContent->getLastInsertId()),
                'fields'=>array('GenericContent.slug')
                )
            );
    
    //Define expectations
    $expected = 'running-a-test';
    
    $this->assertEquals($expected, $result['GenericContent']['slug']);

  }

  /**
   * Simulates the creation of three posts with macthing titles and returns the slugs of each.
   * 
   * @return void
   * @access public
   */
  public function testDisambiguateSlugsWithCommonTitles() {
      
    //Set the common title  
    $createGenericContent = array(
      'GenericContent' => array(
        'title' => 'Running a Test', 
      ),
    );

    //Simulate the first entry
    $this->GenericContent->create();
    $this->GenericContent->save($createGenericContent);

    $result = $this->GenericContent->find('first', 
            array(
                'conditions'=>array('GenericContent.id'=>$this->GenericContent->getLastInsertId()),
                'fields'=>array('GenericContent.slug')
                )
            );
    
    //Define expectations
    $expected = 'running-a-test';
    
    //Simulate the second entry
    $this->GenericContent->create();
    $this->GenericContent->save($createGenericContent);

    $result1 = $this->GenericContent->find('first', 
            array(
                'conditions'=>array('GenericContent.id'=>$this->GenericContent->getLastInsertId()),
                'fields'=>array('GenericContent.slug')
                )
            );
    
    $expected1 = 'running-a-test-1';
    
    //Simulate the third entry
    $this->GenericContent->create();
    $this->GenericContent->save($createGenericContent);

    $result2 = $this->GenericContent->find('first', 
            array(
                'conditions'=>array('GenericContent.id'=>$this->GenericContent->getLastInsertId()),
                'fields'=>array('GenericContent.slug')
                )
            );
    
    //Define expectations
    $expected2 = 'running-a-test-2';
    
    $this->assertEquals($expected, $result['GenericContent']['slug']);
    $this->assertEquals($expected1, $result1['GenericContent']['slug']);
    $this->assertEquals($expected2, $result2['GenericContent']['slug']);
  }
  
  /**
   * Simulates the creation of a canonical link based on a generated slug
   * 
   * @return void
   * @access public
   */
  public function testCreateCanonicalLinkFromTheDerivedSlug() {
      
    $createGenericContent = array(
      'GenericContent' => array(
        'title' => 'Running a Test', 
      ),
    );

    $this->GenericContent->create();
    $this->GenericContent->save($createGenericContent);

    
    $result = $this->GenericContent->find('first', 
            array(
                'conditions'=>array('GenericContent.id'=>$this->GenericContent->getLastInsertId()),
                'fields'=>array('GenericContent.canonical')
                )
            );
    
    //Define expectations
    $expected = Configure::read('Domain.url') . "generic_content/running-a-test/";
    $this->assertEquals($expected, $result['GenericContent']['canonical']);
  }
  
  /**
   * Simulates the creation of a slug based any field specified in the behaviors convert setting
   * 
   * @return void
   * @access public
   */
  public function testCreateSlugUsingTheConvertSetting() {
      
    $createArticle = array(
      'Article' => array(
        'name' => 'Running a Settings Test', 
      ),
    );

    $this->Article->create();
    $this->Article->save($createArticle);

    
    $result = $this->Article->find('first', 
            array(
                'conditions'=>array('Article.id'=>$this->Article->getLastInsertId()),
                'fields'=>array('Article.slug')
                )
            );
    
    //Define expectations
    $expected = 'running-a-settings-test';
    
    $this->assertEquals($expected, $result['Article']['slug']);

  } 
  
  /**
   * Simulates the creation of three posts with macthing name fields (any field specified in the behavior)
   * and returns the slugs of each.
   * 
   * @return void
   * @access public
   */
  public function testDisambiguateSlugsWithCommonNameUsingTheConvertSetting() {
      
    //Set the common title  
    $createArticle = array(
      'Article' => array(
        'name' => 'Running a Settings Test', 
      ),
    );

    //Simulate the first entry
    $this->Article->create();
    $this->Article->save($createArticle);

    $result = $this->Article->find('first', 
            array(
                'conditions'=>array('Article.id'=>$this->Article->getLastInsertId()),
                'fields'=>array('Article.slug')
                )
            );
    
    //Define expectations
    $expected = 'running-a-settings-test';
    
    //Simulate the second entry
    $this->Article->create();
    $this->Article->save($createArticle);

    $result1 = $this->Article->find('first', 
            array(
                'conditions'=>array('Article.id'=>$this->Article->getLastInsertId()),
                'fields'=>array('Article.slug')
                )
            );
    
    $expected1 = 'running-a-settings-test-1';
    
    //Simulate the third entry
    $this->Article->create();
    $this->Article->save($createArticle);

    $result2 = $this->Article->find('first', 
            array(
                'conditions'=>array('Article.id'=>$this->Article->getLastInsertId()),
                'fields'=>array('Article.slug')
                )
            );
    
    //Define expectations
    $expected2 = 'running-a-settings-test-2';
    
    $this->assertEquals($expected, $result['Article']['slug']);
    $this->assertEquals($expected1, $result1['Article']['slug']);
    $this->assertEquals($expected2, $result2['Article']['slug']);
  }

}