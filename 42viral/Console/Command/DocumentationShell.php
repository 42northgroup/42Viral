<?php
/**
 * PHP 5.3
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
 */

App::uses('Utility', 'Lib');

/**
 *
 *
 * 
 */
class DocumentationShell extends AppShell
{
    private $__documentationPath = null;

 
    /**
     * 
     * 
     * @access public
     * @return void
     */
    public function main()
    {
        $this->__documentationPath = ROOT . DS . APP_DIR . DS . '42viral' . DS . 'Documentation/';
        $files = $this->__traverseFilterDocDir();

        foreach($files as $file) {
            $html = $this->__convertMarkdownToHtml($file['full']);

            //[TODO] Save html to _build folder, mirroring the folder hierarchy of the markdown version
        }
    }

    /**
     * Convert an individual markdown file to HTML
     *
     * @access private
     * @param array $file
     * @return string
     */
    private function __convertMarkdownToHtml($file)
    {
        $fileHandle = fopen($file, 'r');
        $fileContent = fread($fileHandle, filesize($file));
        $fileHtmlContent = Utility::markdown($fileContent);
        fclose($fileHandle);

        return $fileHtmlContent;
    }

    /**
     * Takes the documentation path and traverses through the folder looking for markdown files and hierarchy
     *
     * @access private
     * @param string $path
     * @return array
     */
    private function __traverseFilterDocDir()
    {
        $path = $this->__documentationPath;
        $files = array();
        $allowedExtension = array('md');
        
        $fileSPLObjects =  new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        
        try {
            foreach($fileSPLObjects as $fullFileName => $Item) {
                if($Item->isFile()) {
                    $fileName = $Item->getFilename();
                    $path = $Item->getPath();

                    //Skip files without the allowed extensions
                    $pos_dot = strrpos($fileName, "."); // find '.'
                    $fileExtension = ($pos_dot !== false) ? substr($fileName, $pos_dot+1) : null;
                    if(!in_array($fileExtension, $allowedExtension)) {
                        continue;
                    }

                    //Skip files in the _build folder, since that's where the generated doc is placed
                    if(strpos($path, '_build')) {
                        continue;
                    }

                    $files[] = array(
                        'file' => $fileName,
                        'path' => $Item->getPath(),
                        'full' => $fullFileName
                    );
                }
            }
        }
        catch (UnexpectedValueException $e) {
            printf("Directory [%s] contained a directory we can not recurse into", $path);
        }
        
        return $files;
    }
}