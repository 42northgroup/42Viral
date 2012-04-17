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
 * @package       42viral\app
 */

App::uses('Mustache', 'Lib');

/**
 * @package Lib
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 */
class MicroTemplate extends Object
{
    private static $__MI = null;
    private static $__standardTemplateObjects = array();

    /**
     * Initiates Mustache lib
     */
    private static function __init()
    {
        self::$__MI = new Mustache();

        self::$__standardTemplateObjects = array(
            '_server_address' => Configure::read('Domain.url')
        );
    }


/**
 * Expands the objects into the $baseString by using the mappingParams array
 *
 * @access public
 * @param string $baseString the base template string to which the objects need to be applied
 * @param array $templateObjects array of objects with which the $baseString needs to be populated
 * @return string the generated string after expanding objects into the base template string
 */
    public static function applyTemplate($baseString, $templateObjects)
    {
        self::__init();

        $templateObjects = array_merge($templateObjects, self::$__standardTemplateObjects);
        $flattenedTemplateObject = Set::flatten($templateObjects);
        $htmlString = self::$__MI->render($baseString, $templateObjects);

        return $htmlString;
    }

}
