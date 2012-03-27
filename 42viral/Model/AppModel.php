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

App::uses('Model', 'Model');
/**
 *
 * @author Jason D Snider <jason.snider@42viral.org>
 */
class AppModel extends Model {
    
    /**
     * Application-wide behaviors
     * @var array
     * @access public
     */
    public $actsAs = array(
        'Containable', 
        'Log'
    );
    /**
     * Returns the User array of the current user
     * @return type 
     * @access public
     */
    public function currentUser() {
        if(isset($_SESSION['Auth']['User'])) {
            return $_SESSION['Auth']['User'];
        } else {
            return false;
        }
    }
}