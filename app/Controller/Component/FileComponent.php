<?php 
class fileComponent  extends Component {
    
    /**
     * Uses scandir to compile a list of files with in a sinlge directory. 
     * 
     * @author Jason D Snider <jsnider@microtrain.net>
     * @param string $path The path to be scaned
     * @param boolean $rekey If true, the resulting array will be returned with a match $key to $value pair
     * @param mixed $ext Set to null if we want all file ext, otherwise all listed ext will be strpped.
     * @return array 
     */
    function scan($path, $rekey=true, $stripExt=true){
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