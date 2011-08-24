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
    public function oauthed($service, $oauthId){
        $theOauthed = $this->fetchOauthed($service, $oauthId);
        if($theOauthed){
 
            return $theOauthed;
            
        }else{

            return $this->createOauthed($service, $oauthId);
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
    public function createOauthed($service, $oauthId){
        
        //We need an ID for the new Person reocrd
        $personId = String::uuid();
        
        //Build the Oauth record
        $oauthed = array();
        $oauthed['Oauth']['person_id'] = $personId;
        $oauthed['Oauth']['oauth_id'] = $oauthId;
        $oauthed['Oauth']['service'] = $service;

        if($this->save($oauthed)){

            $newOuathId = $this->id;
            
            //Build the Person reocrd
            $oauthedUser = array();
            $oauthedUser['User']['id'] = $personId;
            $oauthedUser['User']['username'] = "{$service}_{$oauthId}";
            $oauthedUser['User']['password'] = Configure::read('Oauth.password');
            $oauthedUser['User']['verify_password'] = Configure::read('Oauth.password');
            
            if($this->User->createUser($oauthedUser['User'])){
                return $personId;
            }else{
                //If the Person record fails, roll back the Oauth record
                $this->delete($newOuathId);
                return false;
            }
            
        }else{
            return false;
        }
    }    
    
}