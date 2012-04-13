<?php
/**
 * PHP 5.3
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

App::uses('File', 'Utility');
App::uses('Configuration', 'Model');
/**
 * Creates a configuration file from stored DB values
 * @package Plugin.ContentFilter
 * @subpackage Plugin.ContentFilter.Console.Command
 * @author Jason D Snider <root@jasonsnider.com>
 */
class ConfigurationShell extends AppShell
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
        $configurationModel = new Configuration();

        $configurations = $configurationModel->find('all', array('contain' => array()));
        
        //$configurations = $this->Configuration->find('all', array('contain' => array()));

        $configureString = "<?php\n";

        foreach ($configurations as $config) {

            //Type detection, this basically determines if we need to quote the value
            switch ($config['Configuration']['type']) {
                case 'string':
                    $configureString .= "Configure::write('{$config['Configuration']['id']}',"
                            . " '{$config['Configuration']['value']}');\n";
                    break;

                default:
                    $configureString .= "Configure::write('{$config['Configuration']['id']}',"
                            . " {$config['Configuration']['value']});\n";
                    break;
            }
        }

        $file = new File(
            ROOT . DS . APP_DIR . DS . 'Config' . DS . 'application.php',
            true,
            0644
        );

        $file->create();
        $file->write($configureString, $mode = 'w', false);
        $file->close();
    }
}