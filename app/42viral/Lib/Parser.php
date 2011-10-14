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
 * Common functionality for parsing stuff
 * @package Lib
 * @author Jason D Snider <jason.snider@42viral.org> 
 */
class Parser
{
 
    /**
     * Converts a data array into an XML 
     * @param type $data
     * @param type $file 
     * @todo Move this to a library
     */
    public static function data2XML($data, $file){
        
        $group=array();
        
        if(isset($data['_Token'])){
            unset($data['_Token']);
        }
        
        if(isset($data['Control'])){
            unset($data['Control']);
        }
        
        $xmlData = array('root' => $data);   
 
        $xmlObject = Xml::fromArray($xmlData, array('format' => 'tags')); 
        $xmlString = $xmlObject->asXML();

        file_put_contents ($file , $xmlString);
    }
    
    /**
     * Parses XML files into config files
     * @param string $path 
     * @return void
     */
    public static function xml2Config($path){
        
        foreach(scandir($path) as $file){
            
            if(is_file($path . DS . $file)){
                
                $xmlData = Xml::toArray(Xml::build($path . DS . $file));
                
                $outFile = 
                    ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . str_replace('.xml', '.php', $file);
                
                $configureString = "<?php\n";

                foreach($xmlData['root'] as $key => $value){
                    $v = empty($value['value'])?$value['default']:$value['value'];
                    $configureString .= "Configure::write('{$value['name']}', {$v});\n";
                }

                file_put_contents ($outFile , $configureString);
            }
            
        }
    }
}