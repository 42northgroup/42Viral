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

echo $this->Form->inputs(array(
    'legend'=>'URL Shortener',

    'ShortURLscheme.id'=>array('value'=>'ShortURL.scheme', 'type'=>'hidden'),
    'ShortURLscheme.value'=>array('label'=>'Short URL Scheme'),

    'ShortURLhost.id'=>array('value'=>'ShortURL.host', 'type'=>'hidden'),
    'ShortURLhost.value'=>array('label'=>'Short URL Host'),
));
        
