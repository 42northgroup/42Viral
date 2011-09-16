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
 * Container for handy functions
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
class Handy
{

    /**
     * Deep conversion of a php object to an array recusively
     *
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access public
     * @param object $obj
     * @return array
     */
    public static function objectToArray($obj)
    {
        $arrObj = is_object($obj) ? get_object_vars($obj) : $obj;

        foreach ($arrObj as $key => $val) {
            $val = (is_array($val) || is_object($val)) ? self::objectToArray($val) : $val;
            $arr[$key] = $val;
        }

        return $arr;
    }
    
    /**
     * Returns a formatted date string, given either a UNIX timestamp or a valid strtotime() date string.
     * This function also accepts a time string and a format string as first and second parameters.
     * In that case this function behaves as a wrapper for TimeHelper::i18nFormat()
     *
     * @param string $format date format string (or a DateTime string)
     * @param string $date Datetime string (or a date format string)
     * @param boolean $invalid flag to ignore results of fromString == false
     * @param integer $userOffset User's offset from GMT (in hours)
     * @return string Formatted date string
     */
    public static function date($time = null, $format = 'm/d/y h:i a', $fail = 'Not Set') {
        $time = self::validTime($time);
        
        if(is_null($time)){
            return $fail;
        }else{
            return date($format, $time);
        }
    }
   
    /**
     * Prevets bad timestamps from defaulting to the epoch
     * @param type $timestamp
     * @return type 
     * 
     * @see http://stackoverflow.com/questions/2224097/prevent-php-date-from-defaulting-to-12-31-1969
     */
    public static function validTime($time, $returnNull = true)
    { 
        
        $returnNull ? null : '0000-00-00 00:00:00';
        
        $time = strtotime($time);
        
        $date = ($time === false) ? $returnNull : $time;
        
        return $date;
        
    }

}