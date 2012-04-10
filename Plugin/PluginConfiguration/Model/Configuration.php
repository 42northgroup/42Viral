<?php
/**
 * Copyright 2012, Jason D Snider (https://jasonsnider.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, Jason D Snider (https://jasonsnider.com)
 * @link https://jasonsnider.com
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Group', 'Model');
App::uses('PluginConfigurationAppModel', 'Plugin/PluginConfiguration/Model');

/**
 * Provides a model for dealing with plugin and application configurations
 * 
 * @package Plugin.ContentFilter
 * @subpackage Plugin.ContentFilter.Model
 * @author Jason D Snider 
 */
class Configuration extends PluginConfigurationAppModel
{
    
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'Configuration';
  
}