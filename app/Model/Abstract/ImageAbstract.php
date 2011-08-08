<?php
App::uses('UploadAbstract', 'Model');
App::uses('UploadInterface', 'Model');

/**
 * Mangages file uploads
 * @package App
 * @subpackage App.core
 */
abstract class ImageAbstract extends UploadAbstract
{
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'Image';
    
    /**
     * 
     * @var string
     * @access public
     */    
    public $alias = 'Image';
    
    /**
     * Inject all "finds" against the Upload object with image filtering criteria
     * @param array $query
     * @return type 
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function beforeFind(&$query) 
    {
        $query['conditions'] =!empty($query['conditions'])?$query['conditions']:array();
        $imageFilter = array('Image.object_type' =>'image');
        $query['conditions'] =array_merge($query['conditions'], $imageFilter);
        
        return true;
    } 
}