<?php
/**
 * Copyright 2012, Jason D Snider (https://jasonsnider.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, Jason D Snider (https://jasonsnider.com)
 * @link https://jasonsnider.com
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('HttpSocket', 'Network/Http');
/**
 * A Behavior for interacting with spam protection APIs.
 * @author Jason D Snider <root@jasonsnider.com>
 */
class AntiSpamableBehavior extends ModelBehavior {
    
    /**
     * @var array
     * @access public 
     */
    public $mapMethods = array();
    
    /**
     * @var object
     * @access public 
     */
    public $HttpSocket = null;
    
    private $__antispamService = null;

    /**
     * @param array
     * @access private
     */
    private $__mappedData = array();

    /**
     * @param array
     * @access public
     */
    public function setup(&$model, $settings = array()){
        $this->HttpSocket = new HttpSocket();
        $this->__antispamService = Configure::read('AntispamService');
        if(!is_array($settings)) {
            $settings = array();
        }

        $this->settings = $settings;
        
        $this->settings['akismetKey'] = Configure::read('Akismet.key');
        
    }

    /**
     * @return boolean
     * @access public
     */
    public function beforeFind(){
        return true;
    }
    
    /**
     * @return boolean
     * @access public
     */
    private function __afterFind(){
        return true;
    }
    
    /**
     * @return boolean
     * @access public
     */
    public function beforeDelete(){
        return true;
    }

    /**
     * @return boolean
     * @access public
     */
    private function __afterDelete(){
        return true;
    }
    
    /**
     * @return boolean
     * @access public
     */
    public function beforeSave(&$model){ 
        $this->__dataMap($model);
        $model->data[$model->alias]['spam_status'] = $this->commentCheck($model);
        return true;
    }

    /**
     * @return boolean
     * @access public
     */
    private function __afterSave(){
        return true;
    }
    
    /**
     * @return boolean
     * @access public
     */
    public function beforeValidate(){
        return true;
    }

    /**
     * A wrapper for verifing service credentials
     * @param type $model
     * @return type 
     */
    public function verifyAccount(&$model){
        switch($this->__antispamService){
            case 'akismet':
                return $this->__akismetVerifyKey($model);
            break;
        
            default:
                return 'You have not defined an antispam service';
            break;    
        }
    }

    /**
     * A wrapper for asking if its spam or ham
     * @param type $model
     * @return type 
     */
    public function commentCheck(&$model){
        switch($this->__antispamService){
            case 'akismet':
                return $this->__akismetCommentCheck($model);
            break;
        
            default:
                return -1;
            break;    
        }
    }

    /**
     * A wrapper for flagging spam 
     * @param type $model
     * @return type 
     */
    public function submitSpam(&$model){
        switch($this->__antispamService){
            case 'akismet':
                return $this->__akismetSubmitSpam($model);
            break;
        
            default:
                return 'You have not defined an antispam service';
            break;    
        }
    }
    
    /**
     * A wrapper for flagging ham
     * @param type $model
     * @return type 
     */
    public function submitHam(&$model){
        switch($this->__antispamService){
            case 'akismet':
                return $this->__akismetSubmitham($model);
            break;
        
            default:
                return 'You have not defined an antispam service';
            break;    
        }
    }    
    
    /**
     * Returns true if a given Akismet key is valid.
     * @param type $model
     * @param array $data
     * @return string
     * @access public 
     */
    private function __akismetVerifyKey(&$model) {

            $response = $this->HttpSocket->post('http://rest.akismet.com/1.1/verify-key', array(
                    'key' => $this->settings['akismetKey'],
                    'blog' => Configure::read('Domain.url')
            ));

            return $response->body;
    }

    /**
     * Returns either "true" (if this is spam) or "false" if it's not.
     * @param type $model
     * @param type $key
     * @param type $data 
     * @return string
     * @access public
     */
    private function __akismetCommentCheck(&$model) { 
     
        $response = $this->HttpSocket->post(
                sprintf('http://%s.rest.akismet.com/1.1/%s', 
                        $this->settings['akismetKey'], 'comment-check'), $this->__mappedData);

       if($response->body == 'true'){
           return 1;
       }elseif($response->body == 'false'){    
           return 0;
       }else{
           $this->log("Akismet Error: {$response->body}", 'Akismet');
           return -1;
       }
       
    }
    
    /**
     * Reports a false negative to the Akismet service
     * @param type $model
     * @param type $key
     * @param type $data 
     * @return string
     */
    private function __akismetSubmitSpam(&$model) {    
        $response = $this->HttpSocket->post(
                sprintf('http://%s.rest.akismet.com/1.1/%s', 
                        $this->settings['akismetKey'], 'submit-spam'), $this->__mappedData);
        return $response->body;
    }
    
    /**
     * Reports a false positive to the Akismet service
     * @param type $model
     * @param type $key
     * @param type $data 
     * @return string
     */
    private function __akismetSubmitHam(&$model) {        
        $response = $this->HttpSocket->post(
                sprintf('http://%s.rest.akismet.com/1.1/%s', 
                        $this->settings['akismetKey'], 'submit-ham'), $this->__mappedData);
        return $response->body;
    }
    
    /**
     * Maps form fields to Akismet 
     * @param array $data
     * @return array
     * @access private
     */
    private function __dataMap(&$model){

        foreach($model->data[$model->alias] as $key => $value){
            if(array_key_exists($key, $this->settings['map'])){
                $this->__mappedData[$this->settings['map'][$key]] = $value;
            }else{
                $this->__mappedData[$key] = $value;
            }
        }
    }
}
