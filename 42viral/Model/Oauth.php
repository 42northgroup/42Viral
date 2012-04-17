<?php
/**
 * Provides a model for creating and maintaining connections between oauth based APIs and user accounts
 * We define an Oauth as an authenticated thrid party service to a Person.
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
 * Provides a model for creating and maintaining connections between oauth based APIs and user accounts
 * We define an Oauth as an authenticated thrid party service to a Person.
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 * @package 42viral\Person\User
 */
class Oauth extends AppModel
{
    /**
     * The static name of the oauth model 
     * @access public
     * @var string     
     */
    public $name = 'Oauth';
    
    /**
     * Specifies the table used by the oauth model
     * @access public
     * @var string
     */
    public $useTable = 'oauths';
    
    /**
     * Defines the belong to relationships for the oauth model
     * @access public
     * @var array
     */
    public $belongsTo = array(
        'Person' => array(
            'className' => 'Person',
            'foreignKey' => 'person_id',
            'dependent' => true
        )
    );

    /**
     * Initialisation for all new instances of Oauth
     * @access public
     * @param mixed $id Set this ID for this model on startup, can also be an array of options, see above.
     * @param string $table Name of database table to use.
     * @param string $ds DataSource connection name.
     * @return void
     */
    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);

        $this->User = new User();
    }
    
    /**
     * If an oauth record exists the the person_id is returned. The an oauthed record does not exist it is created;
     * the person id is returned after the oauth is created
     * @access public
     * @param string $service The service we are checking for: Twitter, Facebook, etc
     * @param string $oauthId The id from the Oauth service, ex. Twitter.member_id
     * @param string $token The authentication token returned by the service (default: null)
     * @param string $userId The id of the for whom we are locating an oauth (default: null)
     * @return string 
     */
    public function oauthed($service, $oauthId, $token=null, $userId=null){
        $theOauthed = $this->getOauthed($service, $oauthId);
        if($theOauthed){

            return $theOauthed;

        }else{

            return $this->createOauthed($service, $oauthId, $token, $userId);
        }
    }

    /**
     * Gets an Oauth record
     * @access public
     * @param string $service
     * @param string $oauthId
     * @return string
     */
    public function getOauthed($service, $oauthId){
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
     * @access public
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
     * @access public
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