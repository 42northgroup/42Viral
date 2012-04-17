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

App::uses('AppModel', 'Model');
/**
 * Manage person notification inbox
 *
 * @package app
 * @subpackage app.core
 *
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 */
class PeopleNotification extends AppModel
{

    /**
     * Model name
     * @access public
     * @var string
     */
    public $name = 'PeopleNotification';

    /**
     * Table the model uses
     * @access public
     * @var string
     */
    public $useTable = 'people_notifications';

    /**
     * Behaviors
     * @access public
     * @var array
     */
    public $actsAs = array(
        'Log'
    );


}
