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
 * @todo What kind of security concerns should be addresses here?
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
        'Scrubable' => array(
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
     * Upload constructor
     * @access public
     * @param mixed $id Set this ID for this model on startup, can also be an array of options, see above.
     * @param string $table Name of database table to use.
     * @param string $ds DataSource connection name.
     *
     */
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);

        $fileWritePath = FILE_WRITE_PATH;
        $imageWritePath = IMAGE_WRITE_PATH;
        $fileReadPath = FILE_READ_PATH;
        $imageReadPath = IMAGE_READ_PATH;
        $ds = DS;

        $this->virtualFields = array(
            'uri' => "CONCAT('/uploaded/', `{$this->alias}`.`id`, '.', `{$this->alias}`.`saved_file_ext`)",

            'thumbnail_image_uri' =>
                "CONCAT('/uploaded/thumbnail_', `{$this->alias}`.`id`, '.', `{$this->alias}`.`saved_file_ext`)",
            /*
            'thumbnail_file_uri' =>
                "CONCAT('/uploaded/thumbnail_', `{$this->alias}`.`id`, '.', `{$this->alias}`.`saved_file_ext`)"
            */
        );

    }

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
     * Processes an uploaded file, creates and entry in the database and save the appropriate files to the uploaded
     * directory
     *
     * @param unknown_type $data
     */
    public function process($data){

        //Do we want to process the upload as an image?
        $isImage = false;

        //Make sure we have a tmp_file to work with
        if(!$this->__hasTmpFile($data[$this->alias]['file']['tmp_name'])){
            return false;
        }

        //Adde the original file name directly to the data array
        $data[$this->alias]['_originalFileName'] = $data[$this->alias]['file']['name'];

        //Try to determine if the uploaded file s an image
        if($this->__isImage($data[$this->alias]['file']['tmp_name'])){

            // This is the file type as it will be saved to the database

            //// We can force all images to be saved as jpg files
            //@@ This file ext. should probably be more configurable
            $data[$this->alias]['saved_file_ext'] = 'jpg';
            $data[$this->alias]['type'] = 'image/jpeg';
            $data[$this->alias]['name']
                = pathinfo($data[$this->alias]['_originalFileName'], PATHINFO_FILENAME)
                . ".{$data[$this->alias]['saved_file_ext']}";

            //// OR ////

            //// We can maintain the original file type
            ## $data['saved_file_ext'] = pathinfo($data['_originalFileName'], PATHINFO_EXTENSION);
            ## $data['name'] = pathinfo($data[$this->alias]['_originalFileName'], PATHINFO_FILENAME);
            ## $data[$this->alias]['type'] = $data[$this->alias]['file']['type'];

            $data[$this->alias]['object_type'] = 'image';
            $isImage = true;

        }else{

            // This is the file type as it will be saved to the database
            // For non-image files we will maintain the original file type
            $data[$this->alias]['saved_file_ext']
                = pathinfo($data[$this->alias]['_originalFileName'], PATHINFO_EXTENSION);
            $data[$this->alias]['name'] = $data[$this->alias]['file']['name'];
            $data[$this->alias]['type'] = $data[$this->alias]['file']['type'];
            $data[$this->alias]['object_type'] = 'file';
        }

        $data[$this->alias]['size'] = $data[$this->alias]['file']['size'];

        if($this->save($data)){
            $data[$this->alias]['id'] = $this->id;
        }else{
            return false;
        }

        //Process and save the files accordingly
        if($isImage){
            return $this->__processImage($data);
        }else{
            return $this->__processFile($data);
        }

        return true;
    }

    /**
     * File processing for basic file uploads
     * @access private
     * @param array $data
     */
    private function __processFile($data){

        $name = $data[$this->alias]['id'];
        $tmpFilePath = $data[$this->alias]['file']['tmp_name'];

        $file = new File ($tmpFilePath);
        $filename = APP . 'webroot' . DS . 'uploaded' . DS . "{$name}.{$data[$this->alias]['saved_file_ext']}";
        $image = $file->read();
        $file->close();
        $file = new File ($filename, true, 777);
        $file->write($image);
        $file->close();

        //Verfiy the file was created, if it wasn't, rollback the database entry
        if(file_exists(APP . 'webroot' . DS . 'uploaded' . DS . "{$name}.{$data[$this->alias]['saved_file_ext']}")){
            return true;
        }else{
            if(!$this->delete($data[$this->alias]['id'])){
                $this->log("{$data[$this->alias]['id']} may not have any associated files", 'UploadRollback');
            }
            return false;
        }
    }

    /**
     * Image processing for file uploads
     * @access private
     * @param array $data
     *
     * @todo Configurable image driver settings
     * @todo Investigate the value of adding salt as they do in the CakePHP plugin
     * @todo Apply a proper autoloader
     */
    private function __processImage($data){

        $name = $data[$this->alias]['id'];
        $_originalFileName = $data[$this->alias]['file']['name'];

        // $driver = 'Gd';
        // $driver = 'Imagick';
        // $driver = 'Gmagick';

        //Path to the Imagine vendor directory
        $path = APP . DS . '42viral' . DS . 'Vendor' . DS . 'Imagine' . DS . 'lib';

        //@@ I really don't like this, but it is functional for the moment
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
        //@@ Thumbnail sizing should probably be configurable
        $size = new Imagine\Image\Box(125, 125);
        $mode = Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND;

        //Configure::write('Imagine.salt', 'your-salt-string-here');

        //Save the original image as the desired format - Set in the processing method
        $imagine
            ->open($data[$this->alias]['file']['tmp_name'])
            ->save(APP . 'webroot' . DS . 'uploaded' . DS . "{$name}.{$data[$this->alias]['saved_file_ext']}");

        //Create a thumbnail and save it in the desired format - Set in the processing method
        $imagine
            ->open(APP . 'webroot' . DS . 'uploaded' . DS . "{$name}.{$data[$this->alias]['saved_file_ext']}")
            ->thumbnail($size, $mode)
            ->save(
                APP . 'webroot' . DS . 'uploaded' . DS . "thumbnail_{$name}.{$data[$this->alias]['saved_file_ext']}");

        //Verfiy the files were created, if they were not, rollback the database entry
        if(
            file_exists(APP . 'webroot' . DS . 'uploaded' . DS . "{$name}.{$data[$this->alias]['saved_file_ext']}")
            && file_exists(
                APP . 'webroot' . DS . 'uploaded' . DS . "thumbnail_{$name}.{$data[$this->alias]['saved_file_ext']}")
        ){
            return true;
        }else{
            if(!$this->delete($data['id'])){
                $this->log("{$data[$this->alias]['id']} may not have any associated files", 'UploadRollback');
            }
            return false;
        }
    }

    /**
     * Deletes the upload record from the database and removes any associated files.
     * @access public
     * @param string $id
     * @retrun boolean
     */
    public function purge($id){
//@@ find the file in the database
//@@ unlink the appropriate files
//@@ remove the record from the database
    }
}