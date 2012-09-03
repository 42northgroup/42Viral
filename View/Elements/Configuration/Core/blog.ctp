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
    'legend' => 'Comment Engine',
    'Commentengine.id' => array(
        'value' => 'Comment.engine',
        'type' => 'hidden'
    ),

    'Commentengine.value' => array(
        'options' => Configure::read('Picklist.Cms.comment_engines'),
        'label' => 'Comment Engine'
    )
));

echo $this->Form->inputs(array(
    'legend' => 'Disqus',
    'Disqusshortname.id' => array('value' => 'Disqus.shortname', 'type' => 'hidden'),
    'Disqusshortname.value' => array('label' => 'Short Name'),
    'Disqusdeveloper.id' => array('value' => 'Disqus.developer', 'type' => 'hidden'),
    'Disqusdeveloper.value' => array('label' => 'Developer'),
));