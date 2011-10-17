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
App::uses('User', 'Model');
App::uses('Sec', 'Utility');

/**
 * Works with Oauth records. An Oauth ties an authenticated thrid party service to a Person.
 *  
 * @package app
 * @subpackage app.core
 * 
 *** @author Jason D Snider <jason.snider@42viral.org>
 */
class OidAssociation extends AppModel
{
    /**
     *
     * @var string
     * @access public
     */
    public $name = 'OidAssociation';
    
    /**
     *
     * @var string
     * @access public
     */
    public $useTable = 'oid_associations';
}