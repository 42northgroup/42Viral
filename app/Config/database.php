<?php
/**
 * This is core configuration file.
 *
 * Use it to configure core behaviour of Cake.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * In this file you set up your database connection details.
 *
 * @package       cake.config
 */
/**
 * Database configuration class.
 * You can specify multiple configurations for production, development and testing.
 *
 * driver => The name of a supported driver; valid options are as follows:
 *		Database/Mysql 		- MySQL 4 & 5,
 *		Database/Sqlite		- SQLite (PHP5 only),
 *		Database/Postgres	- PostgreSQL 7 and higher,
 *		Database/Sqlserver	- Microsoft SQL Server 2005 and higher,
 *		Database/Oracle		- Oracle 8 and higher
 *
 * You can add custom database drivers (or override existing drivers) by adding the
 * appropriate file to app/Model/Datasource/Database.  Drivers should be named 'MyDriver.php',
 *
 *
 * persistent => true / false
 * Determines whether or not the database should use a persistent connection
 *
 * host =>
 * the host you connect to the database. To add a socket or port number, use 'port' => #
 *
 * prefix =>
 * Uses the given prefix for all the tables in this database.  This setting can be overridden
 * on a per-table basis with the Model::$tablePrefix property.
 *
 * schema =>
 * For Postgres specifies which schema you would like to use the tables in. Postgres defaults to 'public'.
 *
 * encoding =>
 * For MySQL, Postgres specifies the character encoding to use when connecting to the
 * database. Uses database default not specified.
 *
 */
/**
 * Data source configuration. Modifieid from the original CakePHP database config file. See app/Config/app.php for 
 * setting the variables
 ** @author Jason D Snider <jason.snider@42viral.org>
 ** @author CakePHP Developers <cakephp.org>
 * @see http://book.cakephp.org/view/922/Database-Configuration
 */
class DATABASE_CONFIG {
    
    /**
     * The default database
     * @var type 
     * @access public
     */
    public $default = array();
    
    /**
     * The test database
     * @var type 
     * @access public
     */
    public $test = array();
    
    /**
     * The test database
     * @var type 
     * @access public
     */
    public $no = array();
    
    /**
     * 
     * @var type 
     * @access public
     */
    public $twitter = array();
    
    /**
     * 
     * @var type 
     * @access public
     */
    public $linkedin = array();
    
    /**
     * 
     * @var type 
     * @access public
     */
    public $facebook = array();
    
    /**
     * 
     * @var type 
     * @access public
     */
    public $yelp = array();
    
    /**
     * 
     * @var type 
     * @access public
     */
    public $yahoo = array();
    
    public function __construct() {  
        
        $this->default = array(
            'datasource' => Configure::read('DataSource.default.datasource'),
            'persistent' => Configure::read('DataSource.default.persistent'),
            'host' => Configure::read('DataSource.default.host'),
            'login' => Configure::read('DataSource.default.login'),
            'password' => Configure::read('DataSource.default.password'),
            'database' => Configure::read('DataSource.default.database'),
            'prefix' => Configure::read('DataSource.default.prefix')
        );

        $this->test = array(
            'datasource' => Configure::read('DataSource.test.datasource'),
            'persistent' => Configure::read('DataSource.test.persistent'),
            'host' => Configure::read('DataSource.test.host'),
            'login' => Configure::read('DataSource.test.login'),
            'password' => Configure::read('DataSource.test.password'),
            'database' => Configure::read('DataSource.test.database'),
            'prefix' => Configure::read('DataSource.test.prefix')
        );
        
        $this->no = array(
            'datasource' => 'No'
        );
        
        $this->twitter = array(
            'datasource' => 'TwitterSource',
            'consumer_key' => Configure::read('Twitter.consumer_key'),
            'consumer_secret' =>Configure::read('Twitter.consumer_secret'),
            'callback' => Configure::read('Twitter.callback')
        );
        
        $this->linkedin = array(
            'datasource' => 'LinkedinSource',
            'consumer_key' => Configure::read('LinkedIn.consumer_key'),
            'consumer_secret' => Configure::read('LinkedIn.consumer_secret'),
            'callback' => Configure::read('LinkedIn.callback')
        );
        
        $this->facebook = array(
            'datasource' => 'FacebookSource',
            'consumer_key' => Configure::read('Facebook.consumer_key'),
            'consumer_secret' => Configure::read('Facebook.consumer_secret'),
            'callback' => Configure::read('Facebook.callback')
        );
        
        $this->yelp = array(
            'datasource' => 'YelpApiSource',
            'consumer_key' => Configure::read('Yelp.consumer_key'),
            'consumer_secret' => Configure::read('Yelp.consumer_secret'),
            'token' => Configure::read('Yelp.token'),
            'token_secret' => Configure::read('Yelp.token_secret')
        );
        
        $this->yahoo = array(
            'datasource' => 'YahooApiSource',
            'app_id' => Configure::read('Yahoo.LocalSearch.app_id')
        );     
    }
}