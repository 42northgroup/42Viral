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

App::build(array(
        'Console' => array(
            ROOT . DS . APP_DIR . DS . 'Plugin' . DS . 'PluginConfiguration' . DS . 'Console' . DS
        ),
    
        'Console/Command' => array(
            ROOT . DS . APP_DIR . DS . 'Plugin' . DS . 'PluginConfiguration' . DS . 'Console' . DS . 'Command'. DS
        ),

    ));


