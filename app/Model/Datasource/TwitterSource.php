<?php

/**
 * Twitter DataSource
 *
 * Used for reading and writing to Twitter, through models.
 *
 * PHP Version 5.x
 *
 * CakePHP(tm) : Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2009, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright Copyright 2009, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link http://cakephp.org CakePHP(tm) Project
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */
App::uses('HttpSocket', 'Network/Http');
App::uses('HttpSocketOauth', 'Lib');

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

    public function read($model, $queryData = array()) {
                
        $url = "http://api.twitter.com/statuses/user_timeline/";

        $url .= "{$queryData['conditions']['username']}.json";
        $response = json_decode(file_get_contents($url), true);
        $results = array();
        foreach ($response as $record) {
            $record = array('Tweet' => $record);
            $record['User'] = $record['Tweet']['user'];
            unset($record['Tweet']['user']);
            $results[] = $record;
        }
        return $results;
    }

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
        pr($result);
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

?>
