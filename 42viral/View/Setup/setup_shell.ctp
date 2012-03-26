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

/**
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */

echo $this->element('Navigation' . DS . 'local', array('section'=>'configuration', 'class'=>'config'));
?>

Run the setup shell from your CakePHP Console
<pre>
    <code>
        cd app
        sudo ./setup.sh www-data username
    </code>
</pre>
<a href="/setup" class="setup-complete">I have ran the setup shell</a>
