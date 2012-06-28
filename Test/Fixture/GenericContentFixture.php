<?php
/**
 * Creates a generic content object for testing behavior functionality outside of the context of an actual data model.
 * This should provide a more pure test of functionality.
 *
 * @package Plugin.Seo
 * @subpackage Plugin.Seo.Test.Fixture
 */
class GenericContentFixture extends CakeTestFixture {

/**
 * name property
 *
 * @var string 'Article'
 * @access public
 */
 public $name = 'GenericContent';

/**
 * fields property
 *
 * @var array
 * @access public
 */
    public $fields = array(
        'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
        'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
        'slug' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 500, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
        'base_slug' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
        'short_cut' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 6, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
        'body' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
        'tease' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 140, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
        'description' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'comment' => 'Meta description tag', 'charset' => 'latin1'),
        'keywords' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'comment' => 'Meta keyword tag', 'charset' => 'latin1'),
        'canonical' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'comment' => 'Your preferred version of a URL for the disambiguation of like content ', 'charset' => 'latin1'),
        'syntax' => array('type' => 'string', 'null' => false, 'default' => 'html', 'length' => 45, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
        'status' => array('type' => 'string', 'null' => false, 'default' => 'draft', 'length' => 45, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
        'custom_file' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
        'object_type' => array('type' => 'string', 'null' => false, 'default' => 'page', 'length' => 45, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
        'parent_content_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
        'created_person_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
        'modified_person_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1'),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
        'deleted' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
        'deleted_person_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'comment' => '', 'charset' => 'latin1')
    );

    /**
     * records property
     *
     * @var array
     * @access public
     */
    /*
    var $records = array(
        array('user_id' => 1, 
        'title' => 'First Article', 
        'base_slug'=>'first-article',
        'slug'=>'first-article',
        'body' => 'First Article Body', 
        'published' => 'Y', 'created' => '2007-03-18 10:39:23', 
        'updated' => '2007-03-18 10:41:31'),

    array('user_id' => 3, 
        'title' => 'Second Article', 
        'body' => 'Second Article Body',
        'base_slug'=>'second-article',
        'slug'=>'second-article',                    
        'published' => 'Y', 
        'created' => '2007-03-18 10:41:23', 
        'updated' => '2007-03-18 10:43:31'),

    array('user_id' => 1, 
        'title' => 'Third Article', 
        'body' => 'Third Article Body', 
        'base_slug'=>'third-article',
        'slug'=>'third-article',                       
        'published' => 'Y', 
        'created' => '2007-03-18 10:43:23', 
        'updated' => '2007-03-18 10:45:31')
    );
    */
}
