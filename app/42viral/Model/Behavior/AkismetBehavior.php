<?php
/**
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */
App::uses('HttpSocket', 'Network/Http');
/**
 * A Behavior for interacting with the Akismet spam protection API.
 */
class AkismetBehavior extends DataSource {
    
    /**
     * @var array
     * @access public 
     */
    public $mapMethods = array();
    
    /**
     * @var object
     * @access public 
     */
	public $Http = null;
    
    public $akismetKey = null;
    public $akismetData = array();
    public $modelData = array();
    public $postRequest = array();
    /**
     * @param array $settings 
     * @access public
     */
    public function setup(&$model, $settings = array()){
        $this->HttpSocket = new HttpSocket();
        Configure::write('Akismet.key', '5c4426c733cd');
        $this->akismetKey = Configure::read('Akismet.key');
        
        if(!is_array($settings)) {
            $settings = array();
        }
        
        $this->settings = $settings;
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
    public function afterFind(){
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
    public function afterDelete(){
        return true;
    }
    
    /**
     * @return boolean
     * @access public
     */
    public function beforeSave(&$model){ 
        //Save Akismets opinion to the database
        $model->data[$model->alias]['is_spam'] = $this->akismetCommentCheck($model);
        
        switch($model->data[$model->alias]['is_spam']){
            case -1:
                $model->data[$model->alias]['status'] = 'pending';
            break;    
        
            case 0:
                $model->data[$model->alias]['status'] = 'approved';
            break;    
        
            case 1:
                $model->data[$model->alias]['status'] = 'denied';
            break;    
                
        }
        
        //debug($model->data[$model->alias]);
        //debug($model);
        //die();
        return true;
    }

    /**
     * @return boolean
     * @access public
     */
    public function afterSave(){
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
     * Returns true if a given Akismet key is valid.
     * @param array $data
     * @return boolean
     * @access public 
     */
	public function verifyKey(&$Model, $data = array()) {

		$response = $this->HttpSocket->post('http://rest.akismet.com/1.1/verify-key', array(
			'key' => $data['key'],
			'blog' => $data['blog'],
		));

		return $response['body']=='valid'?true:false;
	}

    /**
     * Returns either "true" (if this is spam) or "false" if it's not.
     * @param type $key
     * @param type $data 
     * @return boolean
     * @access public
     */
    public function akismetCommentCheck(&$model) { 
        $this->__dataMap($model);
        //debug($this->akismetData);
        
        $response = $this->HttpSocket->post(
                sprintf('http://%s.rest.akismet.com/1.1/%s', $this->akismetKey, 'comment-check'), $this->akismetData);
        
       //debug($response->body); 
        
       if($response['body'] == 'true'){
           return 1;
       }elseif($response['body'] == 'false'){
           return 0;
       }else{
           $this->log("{$model->data[$this->alias]['blog']}, {$response['body']}", 'Conversation');
           return -1;
       }
              
    }
    
    /**
     * Reports a false negative to the Akismet service
     * @param type $model
     * @param type $key
     * @param type $data 
     */
    public function akismetSubmitSpam($key, $data) {    
        $response = $this->HttpSocket->post(sprintf('http://%s.rest.akismet.com/1.1/%s', $key, 'submit-spam'), $data);
    }
    
    /**
     * Reports a false positive to the Akismet service
     * @param type $model
     * @param type $key
     * @param type $data 
     */
    public function akismetSubmitHam(&$model, $key, $data) {        
        $response = $this->HttpSocket->post(sprintf('http://%s.rest.akismet.com/1.1/%s', $key, 'submit-ham'), $data);
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
                $this->akismetData[$this->settings['map'][$key]] = $value;
            }else{
                $this->akismetData[$key] = $value;
            }
        }
    }
}