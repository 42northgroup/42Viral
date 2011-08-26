<?php
App::uses('AppModel', 'Model');
App::uses('User', 'Model');
App::uses('Sec', 'Utility');
/**
 * 
 * @package App
 * @subpackage App.core
 */
abstract class OauthAbstract extends AppModel
{
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'Oauth';
    
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

        $allowRollBack = false;
        
        //Is this an exisiting user?
        if(is_null($userId)){

            //No, this is not an exisiting user. Create the user record.
            $newOuathId = $this->id;

            //Build the Person reocrd
            $oauthedUser = array();
            $oauthedUser['User']['id'] = $userId;
            $oauthedUser['User']['username'] = "{$service}_{$oauthId}";
            $oauthedUser['User']['password'] = Configure::read('Oauth.password');
            $oauthedUser['User']['verify_password'] = Configure::read('Oauth.password');

            if($this->User->createUser($oauthedUser['User'])){
                $userId = $this->User->id;
                $allowRollBack = true;
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
                //If a user was created then we set the rollback flag to true. If this is true and the Oauth could not 
                //be saved, remove the newly created person record as well.  
                if($allowRollBack){
                    $this->Person->delete($userId);
                }
                return false;
            }else{
                //Everything worked out, return the user id
                return $userId;
            }
        }
        
        //If we've come this far, something bad happened
        return false;
    }
    
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
                $db = ConnectionManager::getDataSource('default');
                $tables = $db->listSources();

                $fields = array();

                foreach($tables as $table) {
                    if(!in_array($table, array('aros', 'acos', 'aros_acos'))){
                        
                        $result = $db->query('DESCRIBE '. $table);            
                        $fields =  Set::extract($result, '/COLUMNS/Field');
                        $class_name = Inflector::classify($table);

                        App::uses($class_name, 'Model');
                        $loaded_table = new $class_name();

                        foreach($fields as $field){

                            if(!(strpos($field, 'person_id') === false)){

                                $loaded_table->updateAll(
                                        array($class_name. '.' .$field => "'$user_id'"),
                                        array($class_name. '.' .$field." LIKE '$oauth_person_id'")
                                    );
                            }
                        }
                    }

                }

                $user = new User();
                $user->delete($oauth_person_id);
            }
            return true;
        }else{
            
            return false;
        }
    }
    
}