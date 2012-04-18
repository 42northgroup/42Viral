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
class ProfileUtil
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
}