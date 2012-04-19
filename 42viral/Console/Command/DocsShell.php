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
 * @package 42viral\Console
 */

App::uses('Utility', 'Lib');
App::uses('Doc', 'Model');

/**
 * Cake shell to generate doc (static and/or database) from documentation markdown
 *
 * @package 42viral\Console
 * @subpackage 42viral\Console\Command
 *
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 */
class DocsShell extends AppShell
{
    /**
     * The folder location where all system documentation lives
     *
     * @access private
     * @var string
     */
    private $__docPath = null;

    /**
     * The full path of the folder location where the build documentation lives
     *
     * @access private
     * @var string
     */
    private $__docBuildPath = null;

    /**
     * The parent path of the documentation build folder
     *
     * @access private
     * @var string
     */
    private $__docBuildBasePath = null;

    /**
     * The name to use for the documentation build folder
     *
     * @access private
     * @var string
     */
    private $__docBuildFolder = '_build';

    /**
     * Whether to build static documentation files or not
     *
     * @access private
     * @var boolean
     */
    private $__buildStatic = true;

    /**
     * Main shell entry point
     * 
     * @access public
     * @return void
     */
    public function main()
    {
        //Set the proper values for the documentation paths
        $this->__docPath = ROOT .DS. APP_DIR .DS. '42viral' .DS. 'Doc' .DS;
        $this->__docBuildBasePath = ROOT .DS. APP_DIR .DS. '42viral' .DS. 'Doc' .DS;
        $this->__docBuildPath = $this->__docBuildBasePath . $this->__docBuildFolder .DS;
        
        //Get a hierarchical structure of the source documentation
        $files = $this->__traverseFilterDocDir();

        foreach($files as &$file) {
            $html = $this->__convertMarkdownToHtml($file['full']);
            $file['html'] = $html;

            $tempRelPath = $file['full'];
            $tempRelPath = str_replace($this->__docPath, '', $tempRelPath);
            $tempRelPath = str_replace($file['file'], '', $tempRelPath);

            $file['relative_path_structure'] = preg_split('~' .DS. '~', $tempRelPath, -1, PREG_SPLIT_NO_EMPTY);
        }

        $docModel = new Doc();
        $docModel->saveDocFile($files);

        $this->__clearDocIndexCache();

        if($this->__buildStatic) {
            $this->__buildStaticFiles($files);
        }
    }

    /**
     * Clear the doc index cache file upon running the documentation shell so that a fresh doc index is created on
     * the first access to the docs controller.
     *
     * @access private
     * @return void
     */
    private function __clearDocIndexCache()
    {
        $file = ROOT .DS. APP_DIR .DS. 'tmp' .DS. 'cache' .DS. 'persistent' .DS. 'doc_index';

        if(is_file($file)) {
            unlink($file);
        }
    }

    /**
     * Generate static HTML documentation files from provided markdown and file/folder structure
     *
     * @access private
     * @param array $files
     * @return void
     */
    private function __buildStaticFiles($files)
    {
        $buildPath = $this->__docBuildPath;

        if(file_exists($buildPath)) {
            $this->__clearBuildFolder($buildPath);
        }

        chdir($this->__docBuildBasePath);
        mkdir($this->__docBuildFolder);

        //Duplicate the source documentation folder structure and create the html files within them
        foreach($files as $file) {
            chdir($buildPath);

            foreach($file['relative_path_structure'] as $tempDir) {
                if(!file_exists($tempDir)) {
                    mkdir($tempDir);
                }
                
                chdir(getcwd() .DS. $tempDir);
            }

            $fileToWrite = str_replace('.md', '.html', $file['file']);
            $fileHandle = fopen($fileToWrite, 'w+');
            fwrite($fileHandle, $file['html']);
            fclose($fileHandle);
        }
    }

    /**
     * Clear all files/folder inside a given directory. This is used when re-generating documentation.
     *
     * @access private
     * @param string $dir
     * @return void
     */
    private function __clearBuildFolder($dir)
    {
        //Ensure $dir ends with a slash
        $files = glob($dir . '*', GLOB_MARK);

        foreach($files as $file) {
            if(is_dir($file)) {
                $this->__clearBuildFolder($file);
            } else {
                unlink($file);
            }
        }
        
        rmdir($dir);
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
        $size = filesize($file);

        if($size > 0) {
            $fileContent = fread($fileHandle, $size);
            $fileHtmlContent = Utility::markdown($fileContent);
        } else {
            $fileHtmlContent = '';
        }
        
        fclose($fileHandle);

        return $fileHtmlContent;
    }

    /**
     * Takes the documentation path and traverses through the folder looking for markdown files and hierarchy
     *
     * @access private
     * @return array
     */
    private function __traverseFilterDocDir()
    {
        $path = $this->__docPath;
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
        } catch (UnexpectedValueException $e) {
            printf("Directory [%s] contained a directory we can not recurse into", $path);
        }
        
        return $files;
    }
}