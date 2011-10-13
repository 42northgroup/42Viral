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
 * Common functionality for building site configurations
 * @package Lib
 * @author Jason D Snider <jason.snider@42viral.org> 
 */
class Config
{
 
    /**
     * Converts a data array into an XML 
     * @param type $data
     * @param type $file 
     * @todo Move this to a library
     */
    public static function data2XML($data, $file){
        $group=array();
        unset($data['_Token']);

        //Parse this data into the proper XML structure
        foreach($data as $groupKey => $groupArray){
            
            for($n=0; $n<count($data); $n++){
                
                if(!isset($pointer)){
                   $pointer = $groupKey; 
                }
                
                if($pointer != $groupKey){
                    $pointer = $groupKey;
                }

                foreach($groupArray as $key => $value){

                    if(is_array($value)){

                        $prefix = "{$groupKey}.{$key}";

                        foreach($value as $k => $v){
                            $group[$pointer]['group'][] = array(
                                    'setting' => "{$prefix}.{$k}",
                                    'value' => $v
                                );
                        }
                        

                    }else{

                        $prefix = "{$groupKey}";

                        $group[$pointer]['group'][] = array(
                                'setting' => "{$prefix}.{$key}",
                                'value' => $value
                            );

                    } 
                }
                BREAK;
            }

        }

        $xmlData = array('root' => array('groups'=>$group));   
 
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
                
                foreach($xmlData['root']['groups'] as $groups){
                    
                    foreach($groups['group'] as $group){
                        if(count($group)>1){
                            $configureString .= "Configure::write('{$group['setting']}', '{$group['value']}');\n";
                        }else{
                           $configureString .= 
                                "Configure::write('{$groups['group']['setting']}', {$groups['group']['value']});\n";
                           BREAK;
                        }
                    }
                }
                
                file_put_contents ($outFile , $configureString);
            }
            
        }
    }
}