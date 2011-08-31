<?php

/**
 * Linkedin DataSource
 *
 * Used for reading and writing to Linkedin, through models.
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

class LinkedinSource extends DataSource {

    protected $_schema = array(
        'linkedin' => array(
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
        return array('linkedin');
    }


    /**
     * Used to retrieve a user's statuses. The aouth token and aouth secret 
     * must be passed through the conditions array when making the 'find' 
     * model call
     *
     * @param string $model
     * @param array $queryData
     * @return type 
     */
    public function read($model, $queryData = array()) {
        
        $request = array(
            'uri' => array(
                'scheme' => 'http',
                'host' => 'api.linkedin.com',
                'path' => '/v1/people/~/network/updates',
                'query' => array(
                    'count' => '30'
                )
            ),
            'method' => 'GET',
            'auth' => array(
                'method' => 'OAuth',
                'oauth_consumer_key' => $this->config['consumer_key'],
                'oauth_consumer_secret' => $this->config['consumer_secret'],
                'oauth_token' => $queryData['conditions']['oauth_token'],                
                'oauth_token_secret' => $queryData['conditions']['oauth_token_secret']    
            )            
        );
        
        $response = $this->HttpSocketOauth->request($request);
        
        $response = simplexml_load_string($response);
        $update_content = 'update-content';
        $person_activities = 'person-activities';
        $first_name = 'first-name';
        $last_name = 'last-name';
        

        $results = array();
        foreach ($response->update as $record) {
            $person['person']['id'] = (string)$record->$update_content->person->id;
            $person['person']['first_name'] = (string)$record->$update_content->person->$first_name;
            $person['person']['last_name'] = (string)$record->$update_content->person->$last_name;
            if( isset($record->$update_content->person->$person_activities) ){
                $person['person']['activity'] = (string)$record->$update_content->person->$person_activities->activity->body;
            }else{
                $person['person']['activity'] = '';
            }
            
            $results[] = $person;
        }
        return $results;
    }

    /**
     * Used to update the user's status. The status message, aouth token
     * and aouth secret must be passed into the 'save' model call 
     * 
     * @param string $model
     * @param array $fields
     * @param array $values
     * @return type 
     */
    public function create($model, $fields = array(), $values = array()) {
        
        $data = array_combine($fields, $values);        
                
        
        $xml = new DOMDocument('1.0', 'UTF-8');
            
        $activity = $xml->createElement("activity", '');
        $activity_attr = $xml->createAttribute("locale");
        $activity->appendChild($activity_attr);
        $activity_attr_text = $xml->createTextNode("en US");
        $activity_attr->appendChild($activity_attr_text);
        $xml->appendChild($activity);
        $content_type = $xml->createElement('content-type', 'linkedin-html');
        $activity->appendChild($content_type);
        $body = $xml->createElement('body', $data['status']);
        $activity->appendChild($body);

        $xml = $xml->saveXML();
                
        $request = array(
            'uri' => array(
                'scheme' => 'http',
                'host' => 'api.linkedin.com',
                'path' => '/v1/people/~/person-activities'
            ),
            'method' => 'POST',
            'auth' => array(
                'method' => 'OAuth',
                'oauth_consumer_key' => $this->config['consumer_key'],
                'oauth_consumer_secret' => $this->config['consumer_secret'],
                'oauth_token' => $data['oauth_token'],
                //'oauth_verifier' => $this->params['url']['oauth_verifier'],
                'oauth_token_secret' => $data['oauth_token_secret']
            ),
            'header' => array(                
                'Content-Type' => 'text/xml'
            ),
            'body' => $xml
        );
        
        $result = $this->HttpSocketOauth->request($request);
        
        $result = simplexml_load_string($result);
        
        if (empty ($result)) {            
            return true;
        }
        return false;
    }

    public function describe($model) {
        return $this->_schema['linkedin'];
    }

}

?>
