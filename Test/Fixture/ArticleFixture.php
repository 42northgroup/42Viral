<?php
/**
 * ArticleFixture
 * Copyright 2012, Jason D Snider (https://jasonsnider.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, Jason D Snider (https://jasonsnider.com)
 * @link https://jasonsnider.com
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author Jason D Snider
 */

/**
 * ArticleFixture
 * @package Seo
 * @author Jason D Snider <root@jasonsnider.com>
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
