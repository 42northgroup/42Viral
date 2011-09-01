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
App::uses('UploadAbstract', 'Model');
App::uses('UploadInterface', 'Model');

/**
 * Mangages file uploads
 * 
 * @package app
 * @subpackage app.core
 * 
 * @author Jason D Snider <jsnider77@gmail.com>
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