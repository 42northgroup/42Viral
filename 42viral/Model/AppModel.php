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
 * @package 42viral
 */

App::uses('Model', 'Model');
/**
 * The parent calss for all 42Viral model logic
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral
 */
class AppModel extends Model
{

    /**
     * Application-wide behaviors
     * @access public
     * @var array
     */
    public $actsAs = array(
        'Containable',
        'Log'
    );

    /**
     * Works with ReturnInsertedIds Behaivior to return an array of the ids of inserted rows after a saveAll
     *
     * @access public
     * @var array
     */
    public $insertedIds = array();

    /**
     * Returns the User array of the current user
     * @access public
     * @return string
     */
    public function currentUser()
    {

        if(isset($_SESSION['Auth']['User'])) {
            return $_SESSION['Auth']['User'];
        } else {
            return false;
        }
    }
}