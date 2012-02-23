<?php

/**
 * @package       Test
 * @subpackage    Test.fixtures
 */
class ArticleFixture extends CakeTestFixture {

/**
 * name property
 *
 * @var string 'Article'
 * @access public
 */
	var $name = 'Article';

/**
 * fields property
 *
 * @var array
 * @access public
 */
	var $fields = array(
            'id' => array('type' => 'integer', 'key' => 'primary'),
            'user_id' => array('type' => 'integer', 'null' => false),
            'name' => array('type' => 'string', 'null' => false),
            'base_slug' => array('type' => 'string', 'null' => false),
            'slug' => array('type' => 'string', 'null' => false),
            'body' => 'text',
            'published' => array('type' => 'string', 'length' => 1, 'default' => 'N'),
            'created' => 'datetime',
            'updated' => 'datetime'
	);

    /**
     * records property
     *
     * @var array
     * @access public
     */
    var $records = array(
        array(
            'user_id' => 1, 
            'name' => 'Test Article', 
            'base_slug' => 'test-article',
            'slug' => 'test-article',
            'body' => 'First Article Body', 
            'published' => 'Y', 
            'created' => '2007-03-18 10:39:23', 
            'updated' => '2007-03-18 10:41:31'
        ),
        array(
            'user_id' => 1, 
            'name' => 'Test Article', 
            'base_slug' => 'test-article',
            'slug' => 'test-article-1',
            'body' => 'Second Article Body', 
            'published' => 'Y', 
            'created' => '2007-03-18 10:55:23', 
            'updated' => '2007-03-18 10:56:31'
        ),
    );
}
