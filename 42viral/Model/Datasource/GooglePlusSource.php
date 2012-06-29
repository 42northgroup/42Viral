<?php
/**
 * GooglePlus DataSource
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
App::uses('HttpSocketOauth', 'Lib');

/**
 * GooglePlus DataSource
 *
 * Used for reading and writing to GooglePlus, through models.
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 * @package 42Viral\Connect
 */
class GooglePlusSource extends DataSource {

    /**
     * Defines the GooglePlus API schema
     * @var array
     * @access protected
     */
    protected $_schema = array(
        'google_plus' => array(
            'id' => array(
                'type' => 'string',
                'null' => true,
                'key' => 'primary',
                'length' => 64,
            ),
            'text' => array(
                'type' => 'string',
                'null' => true,
                'key' => 'primary',
                'length' => 140
            ),
            'status' => array(
                'type' => 'string',
                'null' => true,
                'key' => 'primary',
                'length' => 140
            ),
            'oauth_token' => array(
                'type' => 'string',
                'null' => true,
                'key' => 'primary',
                'length' => 140
            )
        )
    );

    /**
     * Initiates the HttpSocketOauth and HttpSocket libraries
     * @param array $request
     * @param array $response
     * @access public
     */
    public function __construct($request = null, $response = null) {
        parent::__construct($request, $response);

        $this->HttpSocketOauth = new HttpSocketOauth();
        $this->HttpSocket = new HttpSocket();
    }

    /**
     * Return a list of sources to be used
     * @return array
     * @access protected
     */
    public function listSources() {
        return array('google_plus');
    }

    /**
     * Used to retrieve a user's news feed. The aouth token must be passed
     * through the conditions array when making the 'find' model call
     *
     * @param string $model
     * @param array $queryData
     * @return array
     */
    public function read($model, $queryData = array()) {

        $request = array(
            'uri' => array(
                'scheme' => 'https',
                'host' => 'www.googleapis.com',
                'path' => '/plus/v1/people/me/activities/public'
            ),
            'method' => 'GET',
            'query' => array(
                'key' => Configure::read('GooglePlus.consumer_key'),
                'alt' => 'json',
                'maxResults' => $queryData['limit']
            ),
            'header' => array(
                'Authorization' => 'OAuth '.$queryData['conditions']['oauth_token']
            )
        );

        $response = json_decode($this->HttpSocketOauth->request($request));

        $results = array();
        foreach ($response->items as $status) {
            $status_update['from'] = $status->actor->displayName;
            $status_update['post'] = $status->title;
            $status_update['time'] = strtotime($status->updated);
            $status_update['source'] = 'googleplus';

            $results[] = $status_update;
        }

        if(!empty ($results)){
            return $results;
        }else{
            return array();
        }
    }

    /**
     * Returns the schema to be used
     *
     * @param array $model
     * @return array
     */
    public function describe($model) {
        return $this->_schema['google_plus'];
    }

}

