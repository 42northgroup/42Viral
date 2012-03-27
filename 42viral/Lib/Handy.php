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
 * @package Lib
 * @subpackage Lib.Handy
 * @author Zubin Khavarian <zubin.khavarian@42viral.org>
 * @author Jason D Snider <jason.snider@42viral.org> 
 */
class Handy
{

    /**
     * Deep conversion of a php object to an array recusively
     *
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
     * ### format:
     *
     * - `DATE` 02/25/2000
     * - `DATETIME` 02/25/2000 09:56 pm
     * - `TIME` 09:56 pm
     * - `REALTIME` 21:25:56:21
     * - `MYSQL` 2000-02-25 21:25:56:21
     * 
     * @param int $time a unix time stamp
     * @param string $date DateTime format
     * @param string $nullMessage the "Not Set" message 
     * @return string either a formatted DateTime string or a "Not Set" message
     */
    public static function date($time, $format = 'DATETIME', $nullMessage = 'Not Set') {
        
        $time = self::validTime($time);
        
        //Deterime the format
        switch($format){
            
            case 'DATE':
                $format = 'm/d/y';
            break;    

            case 'DATETIME':
                $format = 'm/d/y h:i a';
            break;            

            case 'TIME':
                $format = 'h:i a';
            break; 

            case 'REALTIME':
                $format = 'H:i:s';
            break; 
        
            case 'MYSQL':
                $format = 'Y-m-d H:i:s';
            break;    
            
            default:
                $format = $format;
            break;    
        }
        
        if($time){
            return date($format, $time);
        }else{
            return $nullMessage;
        }
    }
   
    /**
     * Prevents bad timestamps from defaulting to the epoch
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
     * Generates a random string of a specified length and character set
     * @param integer $length The length of the string
     * @param boolean $upper Add the A-Z character set
     * @param boolean $lower Add the a-z character set
     * @param boolean $numeric Add the numeric character set
     * @return string 
     */
    public static function random($length = 5, $upper = false, $lower = true, $numeric = true, $special = false){
        
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
        
        if($special){
            $characters .= '!@#$%^&*()-_=+;:\'"<>,./?\\`~';
        }        
           
        $size = strlen( $characters );
        for( $i = 0; $i < $length; $i++ ) {
                $string .= $characters[ rand( 0, $size - 1 ) ];
        }
        
        return $string;
    }
    
    /**
     * Truncates text.
     *
     * Cuts a string to the length of $length and replaces the last characters
     * with the ending if the text is longer than length.
     *
     * ### Options:
     *
     * - `ending` Will be used as Ending and appended to the trimmed string
     * - `exact` If false, $text will not be cut mid-word
     * - `html` If true, HTML tags would be handled correctly
     *
     * @param string $text String to truncate.
     * @param integer $length Length of returned string, including ellipsis.
     * @param array $options An array of html attributes and options.
     * @return string Trimmed string.
     * @link http://book.cakephp.org/view/1469/Text#truncate-1625
     */
    public function truncate($text, $length = 100, $options = array()) {
        $default = array(
            'ending' => '...', 'exact' => true, 'html' => false
        );
        $options = array_merge($default, $options);
        extract($options);

        if (!function_exists('mb_strlen')) {
            class_exists('Multibyte');
        }

        if ($html) {
            if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
                return $text;
            }
            $totalLength = mb_strlen(strip_tags($ending));
            $openTags = array();
            $truncate = '';

            preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
            foreach ($tags as $tag) {
                if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
                    if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
                        array_unshift($openTags, $tag[2]);
                    } else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
                        $pos = array_search($closeTag[1], $openTags);
                        if ($pos !== false) {
                            array_splice($openTags, $pos, 1);
                        }
                    }
                }
                $truncate .= $tag[1];

                $contentLength = 
                    mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
                if ($contentLength + $totalLength > $length) {
                    $left = $length - $totalLength;
                    $entitiesLength = 0;
                    if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, 
                                PREG_OFFSET_CAPTURE)) {
                        foreach ($entities[0] as $entity) {
                            if ($entity[1] + 1 - $entitiesLength <= $left) {
                                $left--;
                                $entitiesLength += mb_strlen($entity[0]);
                            } else {
                                break;
                            }
                        }
                    }

                    $truncate .= mb_substr($tag[3], 0, $left + $entitiesLength);
                    break;
                } else {
                    $truncate .= $tag[3];
                    $totalLength += $contentLength;
                }
                if ($totalLength >= $length) {
                    break;
                }
            }
        } else {
            if (mb_strlen($text) <= $length) {
                return $text;
            } else {
                $truncate = mb_substr($text, 0, $length - mb_strlen($ending));
            }
        }
        if (!$exact) {
            $spacepos = mb_strrpos($truncate, ' ');
            if (isset($spacepos)) {
                if ($html) {
                    $bits = mb_substr($truncate, $spacepos);
                    preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
                    if (!empty($droppedTags)) {
                        foreach ($droppedTags as $closingTag) {
                            if (!in_array($closingTag[1], $openTags)) {
                                array_unshift($openTags, $closingTag[1]);
                            }
                        }
                    }
                }
                $truncate = mb_substr($truncate, 0, $spacepos);
            }
        }
        $truncate .= $ending;

        if ($html) {
            foreach ($openTags as $tag) {
                $truncate .= '</' . $tag . '>';
            }
        }

        return $truncate;
    }

    /**
     * Check whether a given string is a UUID or not (UUIDs have a standard format of '8-4-4-4-12' hexadecimal digits)
     *
     * @access public
     * @param string $string
     * @return bool true if is uuid, false otherwise
     */
    public static function isUUID($string)
    {
        if (eregi("^[0-9a-f]{8}(-[0-9a-f]{4}){3}-[0-9a-f]{12}$", $string)) {

            return true;

        } else {

            return false;

        }
    }
    
    /**
     * Provides standard formatting for phone numbers
     * @param integer $phoneNumber
     * @param boolean $international
     * @param boolean $doNotCall
     * @return string 
     * 
     * @todo How do we detect the system dialer?
     */
    function phoneNumber($phoneNumber, $options = array()){
        
        $defaultOptions = array(
            'international' => false,
            'doNotCall'     => false
        );
        
        $settings = array_merge($defaultOptions, $options);
        
        //initialize $plusOne for international numbers
        $plusOne = null;
        
        //detect the systems dialer
        $dialer = null;
        
        //initialize the dialer protocol
        $protocol = null;
        
        //if the person is flagged as DO NOT CALL then don't
        if($settings['doNotCall']) {
            return '<span class="grayed-out">Do not call</span>';
        }
        
        //if the person is flagged as DO NOT CALL then don't
        if($settings['international']) {
            $plusOne = "+1";
        }

        //Remove all non-numeric cruft
        $phoneNumber = preg_replace('/[^\d]/', '', $phoneNumber);

        //if we have a phone number, build the phone number string
        if ($phoneNumber != "") {
            
            //Make sure we only have 10 digits
            if(strlen($phoneNumber > 10) && strpos($phoneNumber, '1') == 0) {
                $phoneNumber = preg_replace('/^1/', '', $phoneNumber);
            }

            //parse the number into a readable format
            $num1 = substr($phoneNumber, 0, 3);
            $num2 = substr($phoneNumber, 3, 3);
            $num3 = substr($phoneNumber, 6, 4);
            
            //use the dialer to create the right protocol
            switch($dialer):
                
                case 'iphone':
                case 'skype':
                case 'nokia':
                    $protocol = "callto:{$plusOne}{$num1}{$num2}{$num3}";
                break;   
                
                case 'android':
                    $protocol = "wtai://wp/mc;{$plusOne}{$num1}{$num2}{$num3}";
                break;                 
                
                default:
                    $protocol = "tel:{$plusOne}{$num1}{$num2}{$num3}";
                break;   
            
            endswitch;
            
            return "<a href=\"{$protocol}\">({$num1}) {$num2}-{$num3}</a>";
            
        } else {
            return "N/A";
        }
    }    
    
    /**
    * Provides standard formatting for email
    * @param string $phoneNumber
    * @return string 
    */
    function email($email){

        if ($email != "") {
            return "<a href=\"mailto:{$email}\">{$email}</a>";
        } else {
            return "N/A";
        }
    }  
    
}