<?php

/**
 * Facebook DataSource
 *
 * Used for reading and writing to Facebook, through models.
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
 * @author Lyubomir R Dimov <lrdimov@yahoo.com>
 */

class FacebookSource extends DataSource {

    protected $_schema = array(
        'facebook' => array(
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

    public function __construct($request = null, $response = null) {
        parent::__construct($request, $response);

        $this->HttpSocketOauth = new HttpSocketOauth();
        $this->HttpSocket = new HttpSocket();
    }

    public function listSources() {
        return array('facebook');
    }

    /**
     * Used to retrieve a user's news feed. The aouth token must be passed 
     * through the conditions array when making the 'find' model call
     *
     * @param string $model
     * @param array $queryData
     * @return type 
     */
    public function read($model, $queryData = array()) {
                        
        $graph_url = "https://graph.facebook.com/me/statuses?access_token=" 
        . $queryData['conditions']['oauth_token'];
                
        $response = json_decode(file_get_contents($graph_url));
        
        $results = array();
        foreach ($response->data as $status) {
            $status_update['from'] = $status->from->name;
            $status_update['post'] = $status->message;
            $status_update['time'] = strtotime($status->updated_time);
            $status_update['source'] = 'facebook';
            
            $results[] = $status_update;
        }
        
        return $results;
    }

    /**
     * Used to update the user's status. The status message and aouth token
     * must be passed into the 'save' model call 
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
                'scheme' => 'https',
                'host' => 'graph.facebook.com',
                'path' => '/me/feed'
            ),
            'method' => 'POST',
            'body' => array(
                'message' => $data['status'],
                'access_token' => $data['oauth_token']
            )
        );
        
        $response = $this->HttpSocketOauth->request($request);
        $response = json_decode($response, true);
                
        if (isset($response['id'])) {
            $model->setInsertId($response['id']);
            return true;
        }
        return false;
    }

    public function describe($model) {
        return $this->_schema['facebook'];
    }

}

?>