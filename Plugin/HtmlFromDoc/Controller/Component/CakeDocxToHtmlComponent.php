<?php
/**
 * Converts a doc file to html
 * 
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package     Plugin\HtmlFromDoc
 *
 */

/*
App::import('Vendor', 'PostOffice', array(
    'file' => 'post_office/lib/class.PostOffice.php'
));

App::import('Vendor', 'DOCXtoHTML', array(
    'file' => 'post_office/lib/class.DOCX-HTML.php'
));
*/

App::uses('PostOffice', 'HtmlFromDoc.Vendor/PostOffice');
App::uses('DOCXtoHTML', 'HtmlFromDoc.Vendor/PostOffice');

/**
 * Converts a doc file to html
 * 
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @package     Plugin\HtmlFromDoc
 */
class CakeDocxToHtmlComponent extends Component
{
    /**
     * Startup
     *
     * @access public
     * @param object $controller
     */
    public function startup(&$controller){}


    /**
     * Initialize
     *
     * @access public
     * @param object $controller
     */
    public function initialize(&$controller){}


    /**
     * Holds the PostOffice object
     * 
     * @access public
     * @var object
     */
    public $PostOffice = false;


    /**
     * Wrapper for __parseDocXFile
     *
     * @access private
     * @param string $filePath
     * @param boolean $doImages (Default = false)
     * @return string
     */
    private function __giveMeHtmlNow($filePath, $doImages=false)
    {
        $this->PostOffice = new PostOffice($filePath, false /* debug mode */);

        if(!$this->PostOffice) {
            $this->log('The files contents could not be extracted.');
            return '';
        } else {
            $html = $this->__parseDocXFile($filePath, $doImages);

            if(!empty($html)) {
                return $html[0];
            } else {
                return '';
            }
        }
    }


    /**
     * Passing a docx file try and convert it to HTML
     *
     * @access private
     * @param string $filePath
     * @param boolean $doImages (Default = false)
     * @return string
     */
    private function __parseDocXFile($filePath, $doImages=false)
    {
        $pathInfo = pathinfo($filePath);

        //Initiate The DOCX to HTML Class
        $extract = new DOCXtoHTML();
        $extract->docxPath = $filePath;
        $extract->tempDir = $this->PostOffice->tempDir;
        $extract->content_folder =
            strtolower(str_replace("." . $pathInfo['extension'], "", str_replace(" ", "-", $pathInfo['basename'])));

        if($doImages) {
            $extract->keepOriginalImage = true;
            $extract->doImages = true;
        } else {
            $extract->keepOriginalImage = false;
            $extract->doImages = false;
        }
        
        $extract->split = false;
        $extract->allowColor = false;
        $extract->Init($this->PostOffice);

        $rawHtmlData = $extract->output;

        return $rawHtmlData;
    }


    /**
     * Given a file location and folder grab the file if exists and attempt to convert it to an HTML file
     *
     * @access public
     * @param string $uploadedFileName
     * @param boolean $doImages (Default = false)
     * @param string $folderLocation
     * @return string
     */
    public function convertDocumentToHtml($uploadedFileName, $doImages=false, $folderLocation='files/temp/')
    {
        $uploadedFilePath = WWW_ROOT . $folderLocation . $uploadedFileName;
        $resumeHtml = '';

        if(is_file($uploadedFilePath)) {
            $fileInfo = pathinfo($uploadedFilePath);
            $fileExtension = trim(strtolower($fileInfo['extension']));

            //If uploaded file format is from the accepted list then convert
            if(in_array($fileExtension, array('doc', 'rtf'))) {
                $convertCommand =
                    "/usr/bin/libreoffice -headless -convert-to docx -outdir " .
                    WWW_ROOT . $folderLocation . " \"{$uploadedFilePath}\"";

                exec($convertCommand);

                $fileName = preg_replace(
                    "/\.{$fileInfo['extension']}$/i",
                    '.docx',
                    $uploadedFileName
                );

                $newFilePath = WWW_ROOT . $folderLocation . $fileName;

                //Convert DocX to HTML and then delete docx
                if(is_file($newFilePath)) {
                    $resumeHtml = $this->__giveMeHtmlNow($newFilePath, $doImages);
                    unlink($newFilePath);
                }
            } else if($fileExtension == 'docx') {
                //Convert DocX to HTML
                $resumeHtml = $this->__giveMeHtmlNow($uploadedFilePath, $doImages);
            }

            return $resumeHtml;
        } else {
            return '';
        }
    }
}
