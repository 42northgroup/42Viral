<?php
/**
 * Manage person's notification inbox
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
 * @package 42viral\Notification
 */

App::uses('AppModel', 'Model');
/**
 * Manage person's notification inbox
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @package 42viral\Notification
 */
class InboxNotification extends AppModel
{

    /**
     * The static name of the inbox notification object
     * @access public
     * @var string
     */
    public $name = 'InboxNotification';

    /**
     * Sppecifies the table used by the inbox notification  model
     * @access public
     * @var string
     */
    public $useTable = 'inbox_notifications';

    /**
     * Sppecifies the behaviors invoked by the inbox notification  model
     * @access public
     * @var string
     */
    public $actsAs = array(
        'Log'
    );


}
