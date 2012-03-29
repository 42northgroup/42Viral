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

/**
 * @package app
 * @subpackage app.core
 * @author Jason D Snider <jason.snider@42viral.org>
 */
class FileComponent  extends Component 
{
    
    /**
     * Uses scandir to compile a list of files with in a sinlge directory. 
     * 
     * @param string $path The path to be scaned
     * @param boolean $rekey If true, the resulting array will be returned with a match $key to $value pair
     * @param mixed $ext Set to null if we want all file ext, otherwise all listed ext will be strpped.
     * @return array 
     * @access public
     */
    public function scan($path, $rekey=true, $stripExt=true){
        $dir = scandir($path);
        $files = array();
        for($i=0; $i < count($dir); $i++){
            if(is_file($path . DS . $dir[$i])){

                $ext = pathinfo($dir[$i], PATHINFO_EXTENSION);
                $file = ($stripExt)?str_replace(".{$ext}",'',$dir[$i]):$dir[$i];
                $key = ($rekey)?$file:$i;
                $files[$key] = $file;            
            }
        }
        return $files;
    }
}