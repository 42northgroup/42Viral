<?php
App::uses('UploadAbstract', 'Model');
App::uses('UploadInterface', 'Model');

/**
 * Mangages file uploads
 * @package App
 * @subpackage App.core
 */
abstract class FileAbstract extends UploadAbstract
{
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'File';
    
    /**
     * Inject all "finds" against the Upload object with file filtering criteria
     * @param array $query
     * @return type 
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function beforeFind(&$query) 
    {
        $query['conditions'] =!empty($query['conditions'])?$query['conditions']:array();
        $fileFilter = array('File.object_type' =>'file');
        $query['conditions'] =array_merge($query['conditions'], $fileFilter);
        
        return true;
    }  
}