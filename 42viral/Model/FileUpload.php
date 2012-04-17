<?php

/**
 * Deals with uploads from a file point of view
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
 * @package 42viral\Upload\Image
 */

App::uses('AppModel', 'Model');
App::uses('Upload', 'Model');
App::uses('UploadInterface', 'Model');
/**
 * Deals with uploads from a file point of view
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral\Upload\Image
 */
class FileUpload extends Upload
{

    /**
     * The static name of the file upload class
     * @var string
     * @access public
     */
    public $name = 'FileUpload';

    /**
     * Inject all "finds" against the Upload object with file filtering criteria
     * @access public
     * @param array $queryData Holds the conditions used to build the CakePHP query
     * @return array 
     */
    public function beforeFind($queryData)
    {
        parent::beforeFind($queryData);

        $queryData['conditions'] = !empty($queryData['conditions']) ? $queryData['conditions'] : array();
        $fileFilter = array('File.object_type' => 'file');
        $queryData['conditions'] = array_merge($queryData['conditions'], $fileFilter);

        return $queryData;
    }

}