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

/**
 * Provides a list of supported Antispam Services
 * @var array
 */
Configure::write('Picklist.Cms.comment_engines', 
        array(
            'native'=>'Native', 
            'disqus'=>'Disqus')
        );

