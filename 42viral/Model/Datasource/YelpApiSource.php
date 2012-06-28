<?php
/**
 * Yelp data source to make Yelp API access consistent with CakePHP models
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package 42Viral\Connect
 */
App::uses('HttpSocketOauth', 'Lib');

/**
 * Yelp data source to make Yelp API access consistent with CakePHP models
 * @author Zubin Khavarian <zubin.khavarian@42viral.org>
 * @package 42Viral\Connect
 */
class YelpApiSource extends DataSource
{

    /**
     * description
     *
     * @access public
     * @var string
     */
    public $description = 'Yelp API Data Source';
    
    /**
     * yelpHost
     *
     * @access public
     * @var string
     */
    public $yelpHost = 'api.yelp.com';
    
    /**
     * yelpSearchPath
     *
     * @access public
     * @var string
     */
    public $yelpSearchPath = '/v2/search';
    
    
    /**
     * Defines the Yahoo API schema
     * @var array 
     * @access protected
     */
    protected $_schema = array(
        'yelp_api' => array(
            'id' => array(
                'type' => 'string',
                'null' => true,
                'key' => 'primary',
                'length' => 36
            ),
            'name' => array(
                'type' => 'string',
                'null' => true,
                'length' => 180
            ),
            'location' => array(
                'type' => 'string',
                'null' => true,
                'length' => 500
            )
        )
    );

    /**
     * Initiates the HttpSocketOauth and HttpSocket libraries
     * @param array $config
     * @access public
     */
    public function __construct($config = array())
    {
        parent::__construct();
        $this->setConfig($config);

        $this->HttpSocketOauth = new HttpSocketOauth();
    }

    /**
     * Return a list of sources to be used
     * @return array
     * @access protected
     */
    public function listSources()
    {
        return array('yelp_api');
    }

    /**
     * Used to retrieve company reviews from Yelp.
     *
     * @param string $model
     * @param array $queryData
     * @return mixed
     */
    public function read($model, $queryData = array())
    {
        $request = array(
            'uri' => array(
                'host' => $this->yelpHost,
                'path' => $this->yelpSearchPath,
                'query' => $queryData['conditions']
            ),
            'method' => 'GET',
            'auth' => array(
                'method' => 'OAuth',
                'oauth_consumer_key' => $this->config['consumer_key'],
                'oauth_consumer_secret' => $this->config['consumer_secret'],
                'oauth_token' => $this->config['token'],
                'oauth_token_secret' => $this->config['token_secret']
            )
        );

        $yelpResponse = $this->HttpSocketOauth->request($request);
        $resultsObject = json_decode($yelpResponse->body, true);

        return $resultsObject;
    }

    /**
     * Returns the schema to be used
     *
     * @param array $model
     * @return array 
     */
    public function describe($model)
    {
        return $this->_schema['yelp_api'];
    }

}