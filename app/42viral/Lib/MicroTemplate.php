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
 * @package Lib
 * @author Zubin Khavarian <zubin.khavarian@42viral.org>
 */
class MicroTemplate extends Object
{

    private static function __init()
    {
        self::$__serverAddress = Configure::read('Domain.url');
        //self::$__standardTemplateTags = Configure::read('TemplateObjects.standard');
    }

/**
 * Stores a list of standard template tags to be substituted for all strings if they contain the template tag and is
 * set using the 'TemplateObjects.standard' configuration setting.
 *
 * @access private
 * @var array
 */
    private static $__standardTemplateTags = array();
    
    
/**
 * Store the server address for substitution in template string which is set using the
 * 'Domain.url' configuration setting.
 *
 * @access private
 * @var string
 */
    private static $__serverAddress = '';


/**
 * Apply the standard objects to the standard template tags
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @access private
 * @param string $baseString
 * @return string
 */
    private static function __applyStandardTemplateObject($baseString)
    {
        $htmlString = $baseString;

        if(!empty(self::$__standardTemplateTags)) {
            foreach(self::$__standardTemplateTags as $key => $value) {
                $replaceString = $value;
                $templateString = '#{' . $key . '}';
                $htmlString = str_replace($templateString, $replaceString, $htmlString);
            }
        }

        return $htmlString;
    }



/**
 * Apply the server address to the #{server_address} template tag
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @access private
 * @param string $baseString
 * @return string
 */
    private static function __applyServerAddress($baseString)
    {
        $htmlString = $baseString;

        if(!empty(self::$__serverAddress)) {
            $htmlString = str_replace('#{server_address}', self::$__serverAddress, $htmlString);
        }

        return $htmlString;
    }


/**
 * Prevent display of missing tag data by cleaning up any remaining tag pseudo-variables
 * 
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @access private
 * @param type $baseString
 * @return string
 */
    private static function __cleanUp($baseString)
    {
        $htmlString = $baseString;

        if(preg_match('/\#\{.*\}/U', $htmlString) > 0) {
            $htmlString = preg_replace('/\#\{.*\}/U', '', $htmlString);
        }

        return $htmlString;
    }


/**
 * Expands the objects into the $baseString by using the mappingParams array
 *
 * @access public
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @param string $baseString the base template string to which the objects need to be applied
 * @param array $templateObjects array of objects with which the $baseString needs to be populated
 * @return string the generated string after expanding objects into the base template string
 */
    public static function applyTemplate($baseString, $templateObjects)
    {
        self::__init();
        
        $htmlString = self::__applyStandardTemplateObject($baseString);

        $flattenedTemplateObject = Set::flatten($templateObjects);

        if(!empty($flattenedTemplateObject)) {
            foreach($flattenedTemplateObject as $key => $value) {
                $replaceString = $value;
                $templateString = '#{' . $key . '}';
                $htmlString = str_replace($templateString, $replaceString, $htmlString);
            }
        }

        $htmlString = self::__applyServerAddress($htmlString);
        $htmlString = self::__cleanUp($htmlString);

        return $htmlString;
    }

}