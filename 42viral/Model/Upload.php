<?php
/**
 * Mangages file uploads
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package 42viral\Upload
 */

App::uses('AppModel', 'Model');
/**
 * Mangages file uploads
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral\Upload
 */
class Upload extends AppModel
{

    /**
     * The upload model's static name
     * @access public
     * @var string
     */
    public $name = 'Upload';

    /**
     * Defines the table used by the upload model
     * @access public
     * @var string
     */
    public $useTable = 'uploads';

    /**
     * Defines the default behaviors for the upload model
     * @access public
     * @var array
     */
    public $actsAs = array(
        'ContentFilters.Scrubable' => array(
            'Filters' => array(
                'trim' => '*',
                'noHtml' => '*'
            )
        )
    );

    /**
     * Defines the validation parameters for the upload model
     * @access public
     * @var array
     */
    public $validate = array();

    /**
     * Retruns true if a target file is determined to be an image
     * @access private
     * @access string $tmpFile
     * @return boolean
     */
    private function __isImage($tmpFile){
        if(is_array(getimagesize($tmpFile))){
            return true;
        }

        return false;
    }

    /**
     * Returns true if the uploaded file has a tmp_file location
     * @access private
     * @param string $tmpFile
     * @return boolean
     */
    private function __hasTmpFile($tmpFile){

        if(!empty($tmpFile)){
            return true;
        }

        return false;
    }

    /**
     *
     * @param unknown_type $data
     */
    public function process($data){

        debug($data);

        //Make sure we have the tmp_file to work with
        if(!$this->__hasTmpFile($data[$this->alias]['file']['tmp_name'])){
            return false;
        }

        //Try to determine if the uploaded file s an image
        if($this->__isImage($data[$this->alias]['file']['tmp_name'])){
            $this->__processImage($data);
        }else{
            $this->__processFile($data);
        }

        return true;
    }

    private function __processFile(){

    }

    /**
     * Handels image processing for file uploads
     * @access private
     * @todo Configurable image driver settings
     * @todo Investigate the value of adding salt as they do in the CakePHP plugin
     * @todo Apply a proper autoloader
     */
    private function __processImage($data){

        // $driver = 'Gd';
        // $driver = 'Imagick';
        // $driver = 'Gmagick';

        //Path to the Imagine vendor directory
        $path = APP . DS . '42viral' . DS . 'Vendor' . DS . 'Imagine' . DS . 'lib';

        require_once($path . DS . 'Imagine/Exception/Exception.php');
        require_once($path . DS . 'Imagine/Exception/InvalidArgumentException.php');
        require_once($path . DS . 'Imagine/Exception/RuntimeException.php');
        require_once($path . DS . 'Imagine/Image/ManipulatorInterface.php');
        require_once($path . DS . 'Imagine/Image/ImagineInterface.php');
        require_once($path . DS . 'Imagine/Image/ImageInterface.php');
        require_once($path . DS . 'Imagine/Image/BoxInterface.php');
        require_once($path . DS . 'Imagine/Image/PointInterface.php');
        require_once($path . DS . 'Imagine/Image/Point.php');
        require_once($path . DS . 'Imagine/Gd/Imagine.php');
        require_once($path . DS . 'Imagine/Gd/Image.php');
        require_once($path . DS . 'Imagine/Image/Box.php');

        $imagine = new Imagine\Gd\Imagine();
        $size = new Imagine\Image\Box(125, 125);
        $mode = Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;

        $name = String::uuid();
        //Configure::write('Imagine.salt', 'your-salt-string-here');

        //Save the original image
        $imagine
            ->open($data[$this->alias]['file']['tmp_name'])
            ->save(APP . 'webroot' . DS . 'uploaded' . DS . $name . '.png');

        //Save the thumbnail
        $imagine
            ->open(APP . 'webroot' . DS . 'uploaded' . DS . $name . '.png')
            ->thumbnail($size, $mode)
            ->save(APP . 'webroot' . DS . 'uploaded' . DS . 'thumbnail_' . $name . '.png');
    }

}