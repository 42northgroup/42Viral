<?php
/**
 * A utility class for managing plugin configurations
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
 * @package       42viral\Lib
 */
App::uses('Session', 'Component');
/**
 * A utility class for managing plugin configurations
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @package 42viral\Lib
 */
class Utility
{

    /**
     * Noramlizes configuration data so it can easily be saved to the configurations table
     *
     * @access public
     * @static
     * @param array $data
     * @return array
     */
    public static function pluginConfigWrite($data)
    {
        $config = array();
        $x = 0;

        foreach ($data as $key => $value) {
            $config[$x]['Configuration']['id'] = $value['id'];
            $config[$x]['Configuration']['value'] = $value['value'];
            $x++;
        }

        return $config;
    }

    /**
     * Parses and restructures configuration data so that it is automatically read by configuration forms.
     *
     * @access public
     * @static
     * @param array $data
     * @return array
     */
    public static function pluginConfigRead($data)
    {
        $reconfig = array();
        $i = 0;

        foreach ($data as $config) {
            foreach ($config as $k => $v) {
                $reconfig[str_replace('.', '', $v['id'])] = $v;
                $i++;
            }
        }

        return $reconfig;
    }

    /**
     * Returns false if a host is unreachable
     *
     * @access public
     * @static
     * @param string $server
     * @param integer $port
     * @return boolean
     */
    public static function connectionTest($server, $port = 80)
    {
        $fp = fsockopen($server, $port, $errno, $errstr, 10);

        if (!$fp) {
            CakeLog::write('SocketError', "SERVER {$server} PORT {$port} ({$errno}/{$errstr})");
            return false;
        } else {
            return true;
            fclose($fp);
        }
    }

    /**
     * Determine whether the passed array is a purely associative array (all keys are strings) or not
    *
     * @access public
     * @static
     * @param array $array
     * @return boolean
     */
    public static function isPureAssoc($array)
    {
        $flag = true;

        foreach($array as $key => $value) {
            if(is_int($key)) {
                $flag = false;
            }
        }

        return $flag;
    }

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
     * - `MYSQL_TIMESTAMP` 2000-02-25 21:25:56:21
     * - `MYSQL_DATE` 2000-02-25
     *
     * @param int $time a unix time stamp
     * @param string $format DateTime format
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

            case 'MYSQL_TIMESTAMP':
                $format = 'Y-m-d H:i:s';
            break;

            case 'MYSQL_DATE':
                $format = 'Y-m-d';
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
     * @param string $time
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
     * @param boolean $special Add the special character set
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
     * @param array $options
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

            return "<a href=\"tel:{$plusOne}{$num1}{$num2}{$num3}\">({$num1}) {$num2}-{$num3}</a>";

        } else {
            return "N/A";
        }
    }

    /**
    * Provides standard formatting for email
    * @param string $email
    * @return string
    */
    function email($email){

        if ($email != "") {
            return "<a href=\"mailto:{$email}\">{$email}</a>";
        } else {
            return "N/A";
        }
    }

    /**
     * Detects weather you are usign a mobile browser or a standard one
     * @return boolean
     */
    public function isMobile()
    {
        $mobile_browser = '0';

        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android)/i',
            strtolower($_SERVER['HTTP_USER_AGENT']))) {

            $mobile_browser++;
        }

        if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0)
                || ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {

            $mobile_browser++;
        }

        $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
        $mobile_agents = array(
            'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
            'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
            'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
            'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
            'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
            'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
            'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
            'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
            'wapr','webc','winw','winw','xda ','xda-');

        if (in_array($mobile_ua,$mobile_agents)) {
            $mobile_browser++;
        }

        if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini') > 0) {
            $mobile_browser++;
        }

        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows') > 0) {
            $mobile_browser = 0;
        }

        if ($mobile_browser > 0) {
           return true;
        }
        else {
           return false;
        }

    }

    /**
     * Generate a Lorem Ipsum string of a given length
     *
     * @access public
     * @static
     * @param integer $length Length of the required lorem ipsum string (default = 100 characters)
     * @return string
     */
    public static function lipsum($length = 100)
    {
        $text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam dapibus nunc sed sem volutpat et volutpat dolor iaculis. Suspendisse interdum feugiat gravida. Integer sit amet commodo est. Phasellus et ultricies metus. Nunc mollis elit quis ante pellentesque venenatis. Suspendisse quis libero eros, ac aliquam est. Fusce condimentum tincidunt dolor eget sodales. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vestibulum, ipsum vitae dictum malesuada, mi sapien adipiscing leo, vitae molestie lorem lorem sit amet dui. Donec viverra, nibh tristique aliquam convallis, dui quam porta magna, eu scelerisque purus quam sed tortor. Maecenas dapibus interdum leo, et gravida odio tincidunt quis. Cras elementum varius euismod. Cras luctus luctus dolor eu scelerisque.
Quisque eget leo nunc. Morbi in mauris porttitor dui congue malesuada. Maecenas eget elit dui. Nulla facilisi. Nulla bibendum volutpat mattis. Proin enim dui, tempor eget interdum ac, laoreet vitae nisl. Etiam ac ligula nec lectus bibendum porta et non justo. Sed vitae est nisl. Mauris nec lacus tortor, pulvinar bibendum nulla. Phasellus rhoncus nisl sed ligula pretium vel cursus eros placerat. Morbi ac mi et ipsum ultrices scelerisque eget a dolor.
Sed ultrices cursus rhoncus. Cras rhoncus tempus nibh, id convallis quam blandit sit amet. Aenean pretium, lectus sit amet tristique porttitor, quam justo posuere est, eget feugiat purus ante vel nisl. Nunc dapibus nisl nec enim lobortis in mattis metus lobortis. Nulla fringilla, velit volutpat vehicula luctus, erat nulla tincidunt nisl, sed sollicitudin magna nunc nec arcu. Nam feugiat iaculis ultrices. Nullam condimentum turpis quis odio porttitor commodo. Aliquam elementum nulla id lectus placerat sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Pellentesque pharetra lobortis nibh, ac sagittis dui laoreet eu.
Aliquam dictum erat vitae dolor pharetra venenatis. Morbi turpis nibh, pulvinar at sagittis vel, elementum vel lectus. Curabitur aliquet facilisis felis sit amet tincidunt. In tincidunt odio non nibh viverra tincidunt. Nunc ante quam, facilisis nec ullamcorper in, varius a tortor. Morbi leo dui, pulvinar a rutrum eu, pretium ut quam. Proin nec varius nibh. Sed tempus viverra arcu, ac lacinia libero ornare ut. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed a urna a ipsum euismod facilisis. Etiam neque ante, interdum congue bibendum ac, dapibus sed sapien. Suspendisse luctus consequat iaculis. Pellentesque sollicitudin vestibulum ipsum id faucibus. Donec sollicitudin, lectus vitae pellentesque imperdiet, eros mi tempus neque, non eleifend metus felis id leo. Duis a turpis lacus. Mauris imperdiet, quam sed adipiscing gravida, nisi nisi bibendum felis, eu congue risus eros vel diam. Ut adipiscing purus dolor. Sed pulvinar dignissim lorem. Donec quis metus sed nulla eleifend viverra non non ligula.
Nam porttitor tortor quis quam molestie vehicula. In risus urna, sollicitudin laoreet vulputate et, mollis a sem. Praesent cursus tincidunt vestibulum. Donec tristique bibendum odio in iaculis. Pellentesque aliquet est est. Morbi porttitor pharetra lectus, sollicitudin tincidunt lectus egestas eu. Phasellus eget purus velit, eget pulvinar tellus. Donec id pulvinar ipsum. Aliquam erat volutpat. Duis at mauris at erat porttitor bibendum ut sed nunc. Pellentesque ac accumsan ante. In fringilla eros at massa placerat commodo. Aenean in dui ligula, ut interdum quam. Maecenas viverra dolor vitae velit condimentum pulvinar. Mauris mollis luctus augue, vulputate luctus elit interdum vitae.';

        return substr($text, 0, $length);
    }


    /**
     * Generate random lipsum text using external lipsum.com service and a fallback if service fails
     *
     * @access public
     * @static
     * @param integer $amount How much of $what you want.
     * @param string $what Either 'paras', 'words', 'bytes 'or 'lists'.
     * @param integer $start Whether or not to start the result with 'Lorem ipsum dolor sit amet…'
     * @return string
     */
    public static function randomLipsum($amount = 1, $what = 'paras', $start = 0)
    {
        $url = "http://www.lipsum.com/feed/xml?amount=$amount&what=$what&start=$start";

        if(file_get_contents($url, 0, null, 0, 1) !== false) {
            $randomStringObject = simplexml_load_file($url);
        } else {
            $randomStringObject = false;
        }

        if($randomStringObject !== false) {
            return $randomStringObject->lipsum;
        } else {
            return self::lipsum(100);
        }
    }
}