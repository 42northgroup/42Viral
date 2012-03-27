<?php

/* * CLASS PostOffice
 *
 * This class uses the dUnzip2 class from phpclasses.org and requires extension ZLib
 * This class can only handle 1 single file per instance.
 * This class might overrun the execution time limit.
 *
 * Variables that can be set:
 * @see *$docxPath
 * @see $paragraphs
 * @see *$image_max_width
 * @see $mediaDir
 * @see $imagePathPrefix
 *
 * Variables Returned by Class:
 * @see $status
 * @see $output
 * @see $error
 * @see $time
 */

require_once("dUnzip2.inc.php");

class PostOffice
{
    /*
     * @var String This is where the ziped contents will be extracted to for the process
     * @since 1.0
     */

    var $tempDir = "";

    /**
     * @var String The current Status of the class
     * @since 1.0
     */
    var $status = "";

    /**
     * @var Float The time the scipt took to complete the file parsing
     * @since 1.0
     */
    var $time = 0;

    /**
     * @val String The error number generated and the meaning of the error
     * @since 1.0
     */
    var $error = NULL;

    /**
     * This function will set the status to Ready when the class is called. The Constructor Method.
     * @return Bool True when ready
     * @since 1.0
     */
    function __construct($file, $debug)
    {
        return $this->UnZipFile($file, $debug);
    }

    /**
     * This function call the Constructor Method
     * @return Bool True when ready
     * @since 1.0
     */
    function PostOffice($file, $debug)
    {
        return __construct($file, $debug);
    }

    /**
     * This function handles the extracting of the zipped contents to the temp folder
     * @return Bool True on success
     * @since 1.0
     * @modified 1.2.3
     */
    function UnZipFile($file, $debug)
    {
        $targetDir = $this->getUniqueDir();
        $this->tempDir = $targetDir;
        $baseDir = "";
        $maintainStructure = true;
        $unzip = new dUnzip2($file);
        if ($debug == "true") {
            $unzip->debug = true;
        }
        $unzip->unzipAll($targetDir, $baseDir, $maintainStructure);
        unset($unzip);
        if (is_file($this->tempDir . "/[Content_Types].xml")) {
            return true;
        }
        return false;
    }

    /**
     * This function will get a unique directory for the temporary files
     * @return string The first unique directory the function have found
     * @since 1.0
     */
    function getUniqueDir()
    {
        $targetDir = dirname(__FILE__) . "/contents";
        if (!is_dir($targetDir)) {
            return $targetDir;
        }
        $i = 1;
        while (is_dir($targetDir . $i)) {
            $i++;
        }
        $i - 1;
        return $targetDir . $i;
    }

    /**
     * Recursive directory creation based on full path.
     * Will attempt to set permissions on folders.
     * @param string $target Full path to attempt to create.
     * @return bool Whether the path was created or not. True if path already exists.
     * @since 1.0
     */
    function mkdir_p($target)
    {
        // from php.net/mkdir user contributed notes
        $target = str_replace('//', '/', $target);
        if (file_exists($target)) {
            return @is_dir($target);
        }
        // Attempting to create the directory may clutter up our display.
        if (@mkdir($target)) {
            $stat = @stat(dirname($target));
            $dir_perms = $stat['mode'] & 0007777;  // Get the permission bits.
            @chmod($target, $dir_perms);
            return true;
        } elseif (is_dir(dirname($target))) {
            return false;
        }
        // If the above failed, attempt to create the parent node, then try again.
        if (( $target != '/' ) && ( $this->mkdir_p(dirname($target)) )) {
            return $this->mkdir_p($target);
        }
        return false;
    }

    function __destruct()
    {
        if (is_dir($this->tempDir)) {
            //the temp directory still exist
            //$this->rrmdir($this->tempDir);
            return true;
        }
        
        return false;
    }

    /**
     *
     * @param type $dir 
     */
    function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);

            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir") {
                        rrmdir($dir . "/" . $object);
                    } else {
                        unlink($dir . "/" . $object);
                    }
                }
            }

            reset($objects);
            rmdir($dir);
        }
    }
}
