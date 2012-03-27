<?php
/**
 * 
 *
 * @author Zubin Khavarian <zkhavarian@microtrain.net>
 */

App::import('Vendor', 'PostOffice', array(
    'file' => 'post_office/lib/class.PostOffice.php'
));

App::import('Vendor', 'DOCXtoHTML', array(
    'file' => 'post_office/lib/class.DOCX-HTML.php'
));


/**
 *
 */
class CakeDocxToHtmlComponent extends Object
{
    /**
     *
     *
     * @access public
     * @param type $controller
     */
    public function startup(&$controller){}


    /**
     *
     *
     * @access public
     * @param type $controller
     */
    public function initialize(&$controller){}


    /**
     * @access public
     * @var object
     */
    public $PostOffice = false;


    /**
     * Wrapper for __parseDocXFile
     *
     * @access private
     * @param string $filePath
     * @return string
     */
    private function __giveMeHtmlNow($filePath)
    {
        $this->PostOffice = new PostOffice($filePath, false /* debug mode */);

        if(!$this->PostOffice) {
            $this->log('The files contents could not be extracted.');
            return '';
        } else {
            $html = $this->__parseDocXFile($filePath);

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
     * @return string
     */
    private function __parseDocXFile($filePath)
    {
        $pathInfo = pathinfo($filePath);

        //Initiate The DOCX to HTML Class
        $extract = new DOCXtoHTML();
        $extract->docxPath = $filePath;
        $extract->tempDir = $this->PostOffice->tempDir;
        $extract->content_folder =
            strtolower(str_replace("." . $pathInfo['extension'], "", str_replace(" ", "-", $pathInfo['basename'])));

        $extract->image_max_width = 10;
        //$extract->imagePathPrefix = plugins_url();

        $extract->keepOriginalImage = false;
        $extract->doImages = false;
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
     * @param string $folderLocation
     * @return string
     */
    public function convertDocumentToHtml($uploadedFileName, $folderLocation='files/Contacts/')
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
                    $resumeHtml = $this->__giveMeHtmlNow($newFilePath);
                    unlink($newFilePath);
                }
            } else if($fileExtension == 'docx') {
                //Convert DocX to HTML
                $resumeHtml = $this->__giveMeHtmlNow($uploadedFilePath);
            }

            return $resumeHtml;
        } else {
            return '';
        }
    }
}