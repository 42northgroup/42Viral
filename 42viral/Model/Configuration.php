<?php
/**
 * Provides a model for dealing with plugin and application configurations
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */


App::uses('AppModel', 'Model');
/**
 * Provides a model for dealing with plugin and application configurations
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package ContentFilter
 */
class Configuration extends AppModel
{
    /**
     * Provides aa static name for the model
     * @access public
     * @var string
     */
    public $name = 'Configuration';
  
}