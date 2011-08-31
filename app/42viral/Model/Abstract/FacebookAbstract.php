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
 * @author Lyubomir R Dimov <lrdimov@yahoo.com>
 * @package App
 * @subpackage App.core
 */

abstract class FacebookAbstract extends AppModel {

    public $useDbConfig = 'facebook';
    public $useTable = 'facebook';

}

?>
