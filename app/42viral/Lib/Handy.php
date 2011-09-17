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
 ***** @author Zubin Khavarian <zubin.khavarian@42viral.org>
 **** @author Jason D Snider <jason.snider@42viral.org> 
 */
class Handy
{

    /**
     * Deep conversion of a php object to an array recusively
     *
     * @author Zubin Khavarian <zubin.khavarian@42viral.org>
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
     * A wrapper for PHP native date() function. This adds a validation check to prevent the date from falling back
     * to the epoch
     *
     * @param int $time A unix time stamp
     * @param string $date DateTime format
     * @param string $nullMessage The "Not Set" message 
     * @return string Either a formatted DateTime string or Not Set message
     */
    public static function date($time, $format = 'm/d/y h:i a', $nullMessage = 'Not Set') {
        
        $time = self::validTime($time);
        
        if($time){
            return date($format, $time);
        }else{
            return $nullMessage;
        }
    }
   
    /**
     * Prevets bad timestamps from defaulting to the epoch
     * @param string $timestamp
     * @return string 
     * 
     * @see http://stackoverflow.com/questions/2224097/prevent-php-date-from-defaulting-to-12-31-1969
     */
    public static function validTime($time)
    { 
        
        $time = strtotime($time);
        
        $date = ($time === false) ? false : $time;
        
        return $date;
        
    }
    
    /**
     * Generates a random string
     * @param integer $length The length of the string
     * @param boolean $upper Add 
     * @param boolean $lower
     * @param boolean $num
     * @return string 
     */
    public static function random($length = 5, $upper = false, $lower = true, $numeric = true){
        
        $characters = '';
        $string = ''; 

        if($numeric){
            $characters .= '0123456789';
        }
        
        if($lower){
            $characters .= 'abcdefghijklmnopqrstuvwxyz';
        }
        
        if($upper){
            $characters .= 'ABCDEFGHIKLMNOPQRSTUVWXYZ';
        }
           
        $size = strlen( $characters );
        for( $i = 0; $i < $length; $i++ ) {
                $string .= $characters[ rand( 0, $size - 1 ) ];
        }
        
        return $string;
    }

}