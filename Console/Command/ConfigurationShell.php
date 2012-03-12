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

App::uses('File', 'Lib');
/**
 * Creates aconfig file from stored DB values
 * @package Plugin.ContentFilter
 * @subpackage Plugin.ContentFilter.Console.Command
 * @author Jason D Snider <root@jasonsnider.com>
 */
class ConfigurationShell extends AppShell {
    
    public $uses = array('Configuration');
    
    /**
     * @return void
     * @access public
     */
    public function main() 
    {
        $configurations = $this->Configuration->find('all', array('contain'=>array()));
        
        $configureString = "<?php\n";

        foreach($configurations as $config){
            $configureString .= "Configure::write('{$config['Configuration']['id']}',"
                . " '{$config['Configuration']['value']}');\n";
        }

        $file = new File(ROOT . DS . APP_DIR . DS . 'Config' . DS . '42viral.php', true, 0644);
        $file->create();
        $file->write($configureString, $mode = 'w', false);
        $file->close();       
        
    }   
}