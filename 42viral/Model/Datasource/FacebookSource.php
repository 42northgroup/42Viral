<?php
/**
 * Facebook DataSource
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
 * Facebook DataSource
 *
 * Used for reading and writing to Facebook, through models.
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 * @package 42Viral\Connect
 */
class FacebookSource extends DataSource {

    /**
     * Defines the FaceBook API schema
     * @var array 
     * @access protected
     */
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
        return array('facebook');
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
                'host' => 'graph.facebook.com',
                'path' => '/me/statuses',
                'query' => array(
                    'access_token' => $queryData['conditions']['oauth_token'],
                    'limit' => $queryData['limit']
                )
            ),
            'method' => 'GET'
        );

        $response = json_decode($this->HttpSocketOauth->request($request));

        $results = array();
        foreach ($response->data as $status) {
            $status_update['from'] = $status->from->name;
            $status_update['post'] = $status->message;
            $status_update['time'] = strtotime($status->updated_time);
            $status_update['source'] = 'facebook';
            
            $results[] = $status_update;
        }
        
        if(!empty ($results)){
            return $results;
        }else{
            return array();
        }
    }

    /**
     * Used to update the user's status. The status message and aouth token
     * must be passed into the 'save' model call 
     * 
     * @param string $model
     * @param array $fields
     * @param array $values
     * @return boolean
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

    /**
     * Returns the schema to be used
     *
     * @param array $model
     * @return array 
     */
    public function describe($model) {
        return $this->_schema['facebook'];
    }

}

