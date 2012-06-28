<?php
/**
 * Yahoo data source to make Yahoo Local Search API requests consistent with CakePHP models
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
App::uses('HttpSocket', 'Network/Http');

/**
 * Yahoo data source to make Yahoo Local Search API requests consistent with CakePHP models
 * @author Zubin Khavarian <zubin.khavarian@42viral.org>
 * @package 42Viral\Connect
 */
class YahooApiSource extends DataSource
{

    /**
     * description
     *
     * @access public
     * @var string
     */
    public $description = 'Yahoo API Data Source';
    
    /**
     * yahooHost
     *
     * @access public
     * @var string
     */
    public $yahooHost = 'local.yahooapis.com';
    
    /**
     * yahooSearchPath
     *
     * @access public
     * @var string
     */
    public $yahooSearchPath = '/LocalSearchService/V3/localSearch';
    
    /**
     * Standard configuraiton
     *
     * @access public
     * @var array
     */
    public $standardConfig = array();

    /**
     * Defines the Yahoo API schema
     * @var array 
     * @access protected
     */
    protected $_schema = array(
        'yahoo_api' => array(
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

        $this->HttpSocket = new HttpSocket();
        $this->standardConfig = array(
            'appid' => $this->config['app_id'],
            'output' => 'php'
        );
    }

    /**
     * Return a list of sources to be used
     * @return array
     * @access protected
     */
    public function listSources()
    {
        return array('yahoo_api');
    }

    /**
     * Used to retrieve company reviews from Yahoo.
     *
     * @param string $model
     * @param array $queryData
     * @return mixed
     */
    public function read($model, $queryData = array())
    {
        $queryData['conditions'] = array_merge(
            $queryData['conditions'],
            $this->standardConfig
        );


        $request = array(
            'uri' => array(
                'host' => $this->yahooHost,
                'path' => $this->yahooSearchPath,
                'query' => $queryData['conditions']
            ),

            'method' => 'GET'
        );

        $yahooResponse = $this->HttpSocket->request($request);
        $resultsObject = unserialize($yahooResponse->body);

        if(isset($resultsObject['Error'])) {
            return false;
        } elseif($resultsObject['ResultSet']) {
            return $resultsObject['ResultSet'];
        } else {
            return null;
        }
    }


    /**
     * Returns the schema to be used
     *
     * @param array $model
     * @return array 
     */
    public function describe($model)
    {
        return $this->_schema['yahoo_api'];
    }

}
