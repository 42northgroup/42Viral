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
App::uses('HttpSocket', 'Network/Http');

/**
 * Yahoo data source to make Yahoo Local Search API requests consistent with CakePHP models
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.org>
 */
class YahooApiSource extends DataSource
{

    public $description = 'Yahoo API Data Source';
    public $yahooHost = 'local.yahooapis.com';
    public $yahooSearchPath = '/LocalSearchService/V3/localSearch';
    public $standardConfig = array();

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


    
    public function describe($model)
    {
        return $this->_schema['yahoo_api'];
    }

}