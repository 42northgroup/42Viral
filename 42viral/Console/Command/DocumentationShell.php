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
App::uses('File', 'Utility');
App::uses('Configuration', 'Model');

/**
 * Creates a configuration file from stored DB values
 * @package Plugin.ContentFilter
 * @subpackage Plugin.ContentFilter.Console.Command
 * @author Jason D Snider <root@jasonsnider.com>
 */
class DocumentationShell extends AppShell
{
    /**
     * Make the required models accessable to this shell
     * @var array
     * @access public
     */
    public $uses = array('Configuration');
    
    /**
     * @return void
     * @access public
     */
    public function main()
    {
        $documentation_path = ROOT . DS . APP_DIR . DS . '42viral' . DS . 'DocumentationMarkdown';
        echo $documentation_path;
        print_r($this->__fetchFolders($documentation_path));
    }
    
    private function __fetchFolders($path){
        return scandir($path);
    }
}