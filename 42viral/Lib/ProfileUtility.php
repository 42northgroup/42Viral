<?php
/**
 * Container for profile based functions
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
 * @package       42viral\Person\User\Profile
 */

/**
 * Container for profile based functions
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral\Person\User\Profile
 */
class ProfileUtility
{
    /**
     * Returns a person name, if the name is empty then this will return the username
     * @param array $data
     * @return string
     * @access public
     */
    public static function name($data)
    {
        extract($data);

        //Currently this is just looking to see if you have entered your name.
        if (strlen(trim($name)) == 0) {
            return $username;
        } else {
            return $name;
        }
    }

    /**
     * This will allow a user to choose the name they want to display.
     * @param array $data
     * @return string
     * @access public
     */
    public function displayName($data)
    {
        extract($data);

        $display = self::name($data);

        return "<a href=\"{$url}\">{$display}</a>";
    }

    /**
     * Determines the best avatar to use for a target user
     * If the user hasn't uploaded a profile this will fall back to gravatar
     * @param array $data
     * @param $size size of the image we are using for avatar
     * @return string
     * @access public
     */
    public function avatar($data, $size = null)
    {

        $displayName = self::name($data);

        extract($data);

        $link = 'https://secure.gravatar.com/avatar/' . md5(strtolower(trim($email))) . "?r=pg&amp;s={$size}";

        $attr = "width=\"{$size}px\" height=\"{$size}px\" alt=\"{$displayName}\" title=\"{$displayName}\""
            . " class=\"photo\"";

        $url = "<img src=\"{$link}\ {$attr} />";

        return $url;

    }
}