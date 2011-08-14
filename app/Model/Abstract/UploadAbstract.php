<?php
App::uses('AppModel', 'Model');
       
/**
 * Mangages file uploads
 * @package App
 * @subpackage App.core
 * 
 * @todo Name disambiguation
 * @todo Improve whitelist/blacklist data and functionality
 */
abstract class UploadAbstract extends AppModel
{
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'Upload';
    
    /**
     * 
     * @var string
     * @access public 
     */
    public $useTable = 'uploads';
    
    /**
     * 
     * @var array
     * @access public 
     */
    public $actsAs = array(
        'Picklist' => array(
            //An Upload object_type must have a key to upload directory correlation
            'ObjectTypes'=>array(
                'img'=>'Image',
                'file'=>'File'
            )
        ),
        
        'Scrub'=>array(
            'Filters'=>array(
                'trim'=>'*',
                'safe'=>'*'
            )
        )
    );
    /**
     * @var array
     * @access protected
     */
    
    protected $_whitelist = array();
    
    
    /**
     * @var array
     * @access protected
     */
    
    protected $_blacklist = array();    
    
    /**
     *
     * @var array
     * @access public
     */
    public $validate = array();
    
    /**
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function __construct($id = false, $table = null, $ds = null) 
    { 
        parent::__construct($id, $table, $ds);
        
        $this->_setBlacklist();
        $this->_setWhitelist();
        
                
        $this->virtualFields = array(
            'url'=>
                "CONCAT('/',`{$this->alias}`.`object_type`, '/people/', `{$this->alias}`.`created_person_id`, "
                . "'/', `{$this->alias}`.`name`)",
        );          
    }
    
    /**
     * Creates a whitelist of allowable file extensions
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access protected
     */
    protected function _setWhitelist(){
        switch($this->alias){
            case 'File':
                $this->_whitelist = array(
                    'csv' =>  array('text/csv', 'application/vnd.ms-excel', 'text/plain'),
                    'doc' => 'application/msword',
                    'xls' => 'application/vnd.ms-excel',
                    'pdf' => 'application/pdf'
                );
            break;
        
            case 'Image':
                $this->_whitelist = array(
                    'gif' => 'image/gif',
                    'jpe' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'tif' => 'image/tiff',
                    'tiff' => 'image/tiff'
                );
            break;    
        }
    }

    /**
     * Returns a whitelist of allowable file extensions
     * @return array
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function getWhitelist(){
        return $this->_whitelist;
    }
    
    /**
     * Creates a blacklist of forbidden file extensions
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access protected
     */    
    protected function _setBlacklist(){

        $this->_blacklist = array(
            'bin' => 'application/octet-stream'
        );
 
    }
    
    /**
     * Returns a blacklist of forbidden file extensions
     * @retrun array
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function getBlacklist(){
        return $this->_whitelist;
    }
    
    /**
     * Checks the uploaded file against the whitelist and blacklists. The blacklist always takes precedence.
     * @param type $type
     * @param type $name
     * @return type 
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function allowed($name){

        $ext = pathinfo($name, PATHINFO_EXTENSION);
        
        //If the file type is blacklisted, game over.
        if(array_key_exists($ext, $this->_blacklist)){
            return false;
        }
        
        //Check the whitelist, if their is not a match, fail
        if(array_key_exists($ext, $this->_whitelist)){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Manages the process of uploading a file to the server and recording it's existance in the database
     * @param type $data
     * @return type 
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public 
     */
    public function upload($data){

        $this->data = $data;
        //Check against allowable file types
        if($this->allowed($this->data[$this->alias]['file']['name'])){
        
            $this->data[$this->alias] = $this->data[$this->alias]['file'];
            $tmpName = $this->data[$this->alias]['tmp_name'];

            //Only save the file data if the file has been saved
            if($this->save($this->data)){

                $upload = $this->findById($this->id);

                $this->_writePath($_SESSION['Auth']['User']['User']['id']);

                $path = IMAGE_WRITE_PATH . $_SESSION['Auth']['User']['User']['id'] 
                    . DS . basename($upload[$this->alias]['name']); 

                //Try to write the file, remove the DB entry on fail
                if(!$this->_writeFile($tmpName, $path)){
                    $this->delete($this->id);
                    return false;
                }

                //Try to find the file, remove the DB entry on fail
                if(!$this->_checkWrite($path)){
                    $this->delete($this->id);
                    return false;
                }            

                return true;

            }else{

                return false;

            }    
            
        }else{
            
            return false;
            
        }
        
    }
    
    /**
     * Checks for the existance of a target file
     * @param type $path
     * @return type 
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access protected
     */
    protected function _checkWrite($path){
        if(is_file($path)){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Writes a file to the server
     * @param string $tmpName
     * @param string $path
     * @return boolean
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access protected
     */
    protected function _writeFile($tmpName, $path){
        if(move_uploaded_file($tmpName, $path)) {
            return true;
        }else{
            return false;
        }  
    }
    
    /**
     * Makes sure the user has a place to save the file. If not, a new directory is created.
     * @param string $id 
     * @return void
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access protected
     */
    protected function _writePath($id){
        
        //Create the users file directories
        switch($this->alias){
            
            case 'Image':
                if(!is_dir(IMAGE_WRITE_PATH . DS . $id)){
                    mkdir(IMAGE_WRITE_PATH . DS . $id);
                }
                
                if(!is_dir(IMAGE_WRITE_PATH . DS . $id . DS . 'avatar')){
                    mkdir(IMAGE_WRITE_PATH . DS . $id . DS . 'avatar');
                }
                
                if(!is_dir(IMAGE_WRITE_PATH . DS . $id . DS . 'thumbnails')){
                    mkdir(IMAGE_WRITE_PATH . DS . $id . DS . 'thumbnails');
                }                
            break;
            
            case 'File':
                if(!is_dir(FILE_WRITE_PATH . DS . $id)){
                    mkdir(FILE_WRITE_PATH . DS . $id);
                }
            break;
            
        }
    }  
    
    /**
     * Returns a given files ext.
     * @param string $path
     * @return string
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function getExt($path){
        return pathinfo($path, PATHINFO_EXTENSION);
    }
}