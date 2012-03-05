<?php

/**
 * Twitter DataSource
 *
 * Used for reading and writing to Twitter, through models.
 *
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
App::uses('HttpSocketOauth', 'Lib');

/** 
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 */

class TwitterSource extends DataSource {

    protected $_schema = array(
        'tweets' => array(
            'id' => array(
                'type' => 'integer',
                'null' => true,
                'key' => 'primary',
                'length' => 11,
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
            ),
            'oauth_token_secret' => array(
                'type' => 'string',
                'null' => true,
                'key' => 'primary',
                'length' => 140
            ),
        )
    );

    public function __construct($request = null, $response = null) {
        parent::__construct($request, $response);

        $this->HttpSocketOauth = new HttpSocketOauth();
        $this->HttpSocket = new HttpSocket();
    }

    public function listSources() {
        return array('tweets');
    }

    /**
     * Used to retrieve a user's posts. The user's username must 
     * be passed through the conditions array when making the 'find' 
     * model call
     *
     * @param string $model
     * @param array $queryData
     * @return type 
     */
    public function read($model, $queryData = array()) {
                
        $url = "http://api.twitter.com/statuses/user_timeline/";

        $url .= "{$queryData['conditions']['username']}.json";
        
       
        $request = array(
            'uri' => array(
                'scheme' => 'http',
                'host' => 'api.twitter.com',
                'path' => "/statuses/user_timeline/{$queryData['conditions']['username']}.json",
                'query' => array(
                    'count' => $queryData['limit']
                )
            ),
            'method' => 'GET'
        );
        
        $response = json_decode($this->HttpSocketOauth->request($request), true);
        $results = array();
        
        foreach ($response as $record) {
            $record = array('Tweet' => $record);
            $record['User'] = $record['Tweet']['user'];
            $record['post'] = $record['Tweet']['text'];
            $record['time'] = strtotime($record['Tweet']['created_at']);
            $record['source'] = 'twitter';
            
            unset($record['Tweet']['user']);
            $results[] = $record;
        }
        return $results;
    }

    /**
     * Used to post to Twitter. The post message, aouth token, 
     * and aouth secret must be passed into the 'save' model call 
     * 
     * @param string $model
     * @param array $fields
     * @param array $values
     * @return type 
     */
    public function create($model, $fields = array(), $values = array()) {
        
        $data = array_combine($fields, $values);        
                
        $request = array(
            'uri' => array(
                'scheme' => 'http',
                'host' => 'api.twitter.com',
                'path' => '/1/statuses/update.json'
            ),
            'method' => 'POST',
            'auth' => array(
                'method' => 'OAuth',
                'oauth_signature_method' => 'HMAC-SHA1',
                'oauth_consumer_key' => $this->config['consumer_key'],
                'oauth_consumer_secret' => $this->config['consumer_secret'],
                'oauth_token' => $data['oauth_token'],
                'oauth_token_secret' => $data['oauth_token_secret']
            ),
            'body' => array(
                'status' => $data['status']
            )
        );
        
        $result = $this->HttpSocketOauth->request($request);
        
        $result = json_decode($result, true);
        
        if (isset($result['id']) && is_numeric($result['id'])) {
            $model->setInsertId($result['id']);
            return true;
        }
        return false;
    }

    public function describe($model) {
        return $this->_schema['tweets'];
    }

}