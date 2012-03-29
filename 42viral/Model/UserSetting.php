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
App::uses('AppModel', 'Model');

/**
 * Mangages user settings
 *
 * @package app
 * @subpackage app.core
 *
 * @author Lyubomir R Dimov <lrdimov@yahoo.com>
 *
 */
class UserSetting extends AppModel
{

    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'UserSetting';

    /**
     * 
     * @var string
     * @access public 
     */
    public $useTable = 'user_settings';

    /**
     * 
     * @var array
     * @access public 
     */
    public $actsAs = array(
        'Log',
        'AuditLog.Auditable'
    );
    
    /**
     * 
     * @var array
     * @access public 
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'person_id',
            'dependent' => true
        )
    );


    public function fectchUserSettings($personId)
    {
        $userSettings = $this->UserSetting->find('first', array(
            'conditions' => array('UserSetting.person_id' => $personId),
            'contain' => array()
        ));
        
        return $userSettings;
    }
}
?>
