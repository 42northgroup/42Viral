<?php
/**
 * Common functionality for parsing various data sets
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package       42viral\Lib
 */

/**
 * Common functionality for parsing various data sets
 * @author Jason D Snider <jason.snider@42viral.org> 
 * @package 42viral\Lib
 */
class Parser
{
 
    /**
     * Converts a data array into an XML 
     * @access public 
     * @static
     * @param array $data
     * @param array $file
     */
    public static function data2XML($data, $file){
        
        $group=array();
        
        if(isset($data['_Token'])){
            unset($data['_Token']);
        }
        
        if(isset($data['Control'])){
            unset($data['Control']);
        }
        
        $encodedData = self::arrayEncodeXML($data);  

        $xmlData = array('root' => $encodedData);   
 
        $xmlObject = Xml::fromArray($xmlData, array('format' => 'tags')); 
        $xmlString = $xmlObject->asXML();

        file_put_contents ($file , $xmlString);
    }
    
    /**
     * Parses XML files into config files
     * @access public 
     * @static
     * @param string $path 
     *
     */
    public static function xml2Config($path){
        
        foreach(scandir($path) as $file){
            $ext = pathinfo($file, PATHINFO_EXTENSION);

            //Skip file if it's not XML
            if(strtolower($ext) !== 'xml') {
                continue;
            }
            
            if(is_file($path . DS . $file)){
                
                $xmlData = Xml::toArray(Xml::build($path . DS . $file));
                
                $outFile = 
                    ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . str_replace('.xml', '.php', $file);
                
                $configureString = "<?php\n";

                foreach($xmlData['root'] as $key => $value){
                    $val = empty($value['value'])?$value['default']:$value['value'];
                    $decoded = htmlspecialchars_decode($val, ENT_QUOTES);
                    $configureString .= "Configure::write('{$value['name']}', {$decoded});\n";
                }
                
                file_put_contents ($outFile , $configureString);
            }
            
        }
        
    }
    
    /**
     * Encodes array data with XML safe formatting
     * @access public 
     * @static
     * @param array $data
     * @return array
     */
    public static function arrayEncodeXML($data){
        $encodedData = array();
        foreach($data as $key => $value){
            foreach($value as $k => $v){
                $encodedData[$key][$k] = htmlspecialchars($v, ENT_QUOTES);
            }
        }
        return $encodedData;
    }
    
    /**
     * Decodes XML safe formatting contained with in an array. 
     * @access public 
     * @static
     * @param array $data
     * @return array
     */
    public static function arrayDecodeXML($data){
        $decodedData = array();
        foreach($data as $key => $value){
            foreach($value as $k => $v){
                $decodedData[$key][$k] = htmlspecialchars_decode($v, ENT_QUOTES);
            }
        }
        return $decodedData;
    }
    
    /**
     * Noramlizes configuration data so it can easily be saved to the configurations table
     * @access public 
     * @static
     * @param array $data
     * @return array
     */
    public static function pluginConfigWrite($data){
        $config = array();
        $x=0;
        foreach($data as $key=>$value){
            $config[$x]['Configuration']['id']=$value['id'];
            $config[$x]['Configuration']['value']=$value['value'];
            $x++;
        }
        return $config;
    }

        
    /**
     * Parses and restructures configuration data so that it is automatically read by configuration forms. 
     * @access public 
     * @static
     * @param array $data
     * @return array
     */
    public static function pluginConfigRead($data){
        $reconfig = array();
        $i=0;
        foreach($data as $config){
           foreach($config as $k => $v){
               $reconfig[str_replace('.', '', $v['id'])]=$v; 
                $i++;
           }
        }
        return $reconfig;
    }
}