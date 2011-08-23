<?php
App::uses('AppModel', 'Model');
App::uses('Person', 'Model');
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
    
    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        
        $this->Person = new Person();
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
                    ),
                    'contain'=>array(
                        'Person'=>array()
                    )
                )
            );
        
        if(!empty($oauthed)){
            return $oauthed['Person']['id'];
        }else{
            return false;
        }
    }
    
    /**
     * Creates a new OAuth entry and person
     * @param string $service
     * @param string $oauthId
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
            $oauthedPerson = array();
            $oauthedPerson['Person']['id'] = $personId;
            
            if($this->Person->save($oauthedPerson)){
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