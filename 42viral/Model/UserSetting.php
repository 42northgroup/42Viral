<?php
/**
 * Mangages user settings
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
 * @package 42viral\Person\User
 */

App::uses('AppModel', 'Model');
/**
 * Mangages user settings
 * @author Lyubomir R Dimov <lrdimov@yahoo.com>
 * @package 42viral\Person\User
 */
class UserSetting extends AppModel
{

    /**
     * The static name of the user setting class 
     * @access public
     * @var string
     */
    public $name = 'UserSetting';

    /**
     * Specifies the table used by the user setting model
     * @access public
     * @var string 
     */
    public $useTable = 'user_settings';

    /**
     * Specifies the behaviors invoked by the user setting object
     * @access public
     * @var array 
     */
    public $actsAs = array(
        'AuditLog.Auditable',
        'Log'
    );
    
    /**
     * Defines the user setting's belongs to relationships
     * @access public 
     * @var array
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'person_id',
            'dependent' => true
        )
    );
}
?>
