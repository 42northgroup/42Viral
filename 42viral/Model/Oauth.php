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

App::uses('AppModel', 'Model');
App::uses('User', 'Model');
App::uses('Profile', 'Model');
App::uses('Sec', 'Utility');

/**
 * Works with Oauth records. An Oauth ties an authenticated thrid party service to a Person.
 *  
 * @package app
 * @subpackage app.core
 * 
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 */
class Oauth extends AppModel
{
    /**
     *
     * @var string
     * @access public
     */
    public $name = 'Oauth';
    
    /**
     *
     * @var string
     * @access public
     */
    public $useTable = 'oauths';
    
   /**
     *
     * @var array
     * @access public
     */
    public $belongsTo = array(
        'Person' => array(
            'className' => 'Person',
            'foreignKey' => 'person_id',
            'dependent' => true
        )
    );

    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);

        $this->User = new User();
    }

    /**
     * Wraps the checking and creation logic
     * @param string $service
     * @param string $oauthId
     * @return string
     */
    public function oauthed($service, $oauthId, $token=null, $user_id=null){
        $theOauthed = $this->fetchOauthed($service, $oauthId);
        if($theOauthed){

            return $theOauthed;

        }else{

            return $this->createOauthed($service, $oauthId, $token, $user_id);
        }
    }

    /**
     * Fetches an Oauth record
     * @param string $service
     * @param string $oauthId
     * @return string
     */
    public function fetchOauthed($service, $oauthId){
        $oauthed =
            $this->find('first',
                array(
                    'conditions'=>array(
                        'Oauth.service'=>$service,
                        'Oauth.oauth_id'=>$oauthId
                    )
                )
            );

        if(!empty($oauthed)){
            return $oauthed['Oauth']['person_id'];
        }else{
            return false;
        }
    }

    /**
     * Creates a new OAuth entry and person
     * @param string $service
     * @param string $oauthId The id from the Oauth service, ex. Twitter.member_id
     * @return string
     */
    public function createOauthed($service, $oauthId, $token=null, $userId=null){

        //Is this an exisiting user?
        if(is_null($userId)){

            //Build the Person reocrd
            $oauthedUser = array();
            $oauthedUser['User']['username'] = "{$service}_{$oauthId}";
            $oauthedUser['User']['password'] = Configure::read('Oauth.password');
            $oauthedUser['User']['verify_password'] = Configure::read('Oauth.password');

            if($this->User->createUser($oauthedUser['User'])){

                $userId = $this->User->id;

                $oauthed = array();
                $oauthed['Oauth']['person_id'] = $userId;
                $oauthed['Oauth']['oauth_id'] = $oauthId;
                $oauthed['Oauth']['service'] = $service;
                $oauthed['Oauth']['token'] = $token;

                if($this->save($oauthed)){
                    return $userId;
                }
            }else{
                //The save failed, get out
                return false;
            }

        }

        if(!is_null($userId)){
            //Build the Oauth record
            $oauthed = array();
            $oauthed['Oauth']['person_id'] = $userId;
            $oauthed['Oauth']['oauth_id'] = $oauthId;
            $oauthed['Oauth']['service'] = $service;
            $oauthed['Oauth']['token'] = $token;

            if($this->save($oauthed)){
                return $userId;
            }else{
                //Everything worked out, return the user id
                return $userId;
            }
        }

        //If we've come this far, something bad happened
        return false;
    }

    
    /**
     * Checks to see if the user has used this service to authenticate themselves
     * if the past and if they are cuurently logged in using that service. 
     * 
     * If they are logged using once service and authenticate using another, the
     * second once will be merged into the first one and it will return true.
     * 
     * If this is the first time the user is authenticating with this service it will
     * return false 
     *
     * @param stirng $service
     * @param stirng $service_id
     * @param string $user_id
     * @return bollean
     */

    public function doesOauthExist($service, $service_id, $user_id)
    {
        $oauth = $this->find('first', array(
            'conditions' => array(
                    'Oauth.service' => $service,
                    'Oauth.oauth_id' => $service_id
                )
        ));

        if(!empty ($oauth)){
            
            if($oauth['Oauth']['person_id'] != $user_id){
                
                $oauth_person_id = $oauth['Oauth']['person_id'];
                
                $profile = new Profile();
                $profile->deleteAll(array('Profile.owner_person_id' => $oauth_person_id));

                $db = ConnectionManager::getDataSource('default');
                $tables = $db->listSources();

                $fields = array();
                
                foreach($tables as $table) {
                    if(!in_array($table, array('aros', 'acos', 'aros_acos'))){

                        $result = $db->query('DESCRIBE '. $table);
                        $fields =  Set::extract($result, '/COLUMNS/Field');
                        $class_name = Inflector::classify($table);

                        /*
                        
                        if(class_exists($class_name)){
                            $loaded_table = ClassRegistry::init($class_name);
                        }else{
                            
                            $pluginDirs = App::objects('plugin', null, false);
        
                            foreach ($pluginDirs as $pluginDir){
                                if(file_exists('Plugin'. DS .$pluginDir. DS .'Model'. DS .$class_name.'php')){
                                    App::import('Model', $pluginDir.'.'.$class_name);
                                    
                                    if(class_exists($class_name)){
                                        $loaded_table = ClassRegistry::init($class_name);
                                    }else{
                                        echo 'class not found';
                                    }
                                }else{
                                    echo 'model not found';
                                }
                            }
                        }
                        
                        if(!isset ($loaded_table)){
                            $loaded_table = ClassRegistry::init($class_name);
                        }
                        
                         * 
                         */
                        
                        foreach($fields as $field){

                            if(!(strpos($field, 'person_id') === false)){
                                
                                $query = "UPDATE {$table} SET $table.$field = '{$user_id}'
                                            WHERE $table.$field LIKE '$oauth_person_id'";
                                
                                $this->query($query);
                                
                                $query = "";

                                /*
                                $loaded_table->updateAll(
                                        array($class_name. '.' .$field => "'$user_id'"),
                                        array($class_name. '.' .$field." LIKE '$oauth_person_id'")
                                    );
                                 * 
                                 */
                            }
                        }
                        
                    }

                }

                App::uses('User', 'Model');
                $user = ClassRegistry::init('User');
                $user->delete($oauth_person_id);
                
            }
            return true;
        }else{

            return false;
        }
    }

}