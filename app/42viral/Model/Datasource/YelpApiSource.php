<?php
/**
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('HttpSocketOauth', 'Lib');

/**
 * Yelp data source to make Yelp API access consistent with CakePHP models
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.org>
 */
class YelpApiSource extends DataSource
{

    public $description = 'Yelp API Data Source';
    public $yelpHost = 'api.yelp.com';
    public $yelpSearchPath = '/v2/search';
    
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

    public function __construct($config = array())
    {
        parent::__construct();
        $this->setConfig($config);

        $this->HttpSocketOauth = new HttpSocketOauth();
    }

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

    public function describe($model)
    {
        return $this->_schema['yelp_api'];
    }

}