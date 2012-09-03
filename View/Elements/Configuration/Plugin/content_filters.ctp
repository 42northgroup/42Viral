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
            'legend'=>'Antispam Service',
            'AntispamService.id'=>array(
                'value'=>'AntispamService', 'type'=>'hidden'),

            'AntispamService.value'=>array(
                'options'=>Configure::read('Picklist.ContentFilter.AntispamServices'),
                'label'=>'Antispam Service'),
        ));

    echo $this->Form->inputs(array(
            'legend'=>'Akismet Settings',
            'Akismetkey.id'=>array('value'=>'Akismet.key', 'type'=>'hidden'),

            'Akismetkey.value'=>array('label'=>'Akismet Key'),
        ));