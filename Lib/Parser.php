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
     * @access public 
     * @static
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
     * 
     *
     * @access public
     * @param array $dbConfig
     * @param string $sourceFile
     * @return void
     * @static
     */
    public static function dbConfig2XML($dbConfig, $sourceFile, $targetFile)
    {
        $xmlData = Xml::toArray(Xml::build($sourceFile));

        foreach($xmlData['root'] as $key => &$tempRecord) {
            $tempRecord['value'] = $dbConfig[$key];
        }

        $xmlObject = Xml::fromArray($xmlData, array('format' => 'tags'));
        $xmlString = $xmlObject->asXML();

        file_put_contents ($targetFile , $xmlString);
    }

    
    /**
     * Parses XML files into config files
     * 
     * @param string $path 
     * @return void
     * @access public 
     * @static
     */
    public static function xml2Config($path)
    {
        foreach (scandir($path) as $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);

            //Skip file if it's not XML
            if (strtolower($ext) !== 'xml') {
                continue;
            }

            if (is_file($path . DS . $file)) {

                $xmlData = Xml::toArray(Xml::build($path . DS . $file));

                $outFile =
                        ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Includes' . DS . str_replace('.xml', '.php', $file);

                $configureString = "<?php\n";

                foreach ($xmlData['root'] as $key => $value) {
                    $val = empty($value['value']) ? $value['default'] : $value['value'];
                    $rawValue = $val;
                    $decoded = htmlspecialchars_decode($val, ENT_QUOTES);

                    if (isset($value['type'])) {
                        switch ($value['type']) {
                            case 'boolean':
                                if(in_array(strtolower($decoded), array('1', 'yes', 'true', 'on'))) {
                                    $configureString .= "Configure::write('{$value['name']}', true);\n";
                                } elseif(in_array(strtolower($decoded), array('0', 'no', 'false', 'off'))) {
                                    $configureString .= "Configure::write('{$value['name']}', false);\n";
                                } else {
                                    $configureString .= "Configure::write('{$value['name']}', '{$rawValue}');\n";
                                }
                                break;

                            case 'integer':
                            case 'array':
                                $configureString .= "Configure::write('{$value['name']}', {$rawValue});\n";
                                break;

                            default: //string
                            case 'string':
                                $configureString .= "Configure::write('{$value['name']}', '{$decoded}');\n";
                                break;
                        }
                    } else {
                        $configureString .= "Configure::write('{$value['name']}', '{$decoded}');\n";
                    }
                }

                file_put_contents($outFile, $configureString);
            }
        }
    }

    
    /**
     * Encodes array data with XML safe formatting
     * @param type $data
     * @return type 
     * @access public 
     * @static
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
     * @param type $data
     * @return type
     * @access public 
     * @static
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
     * @param type $data
     * @return type
     * @access public 
     * @static
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
     * @param type $data
     * @return type
     * @access public 
     * @static
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