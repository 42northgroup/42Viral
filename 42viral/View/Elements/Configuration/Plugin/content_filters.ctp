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
            'ContentFiltersAntispamService.id'=>array(
                'value'=>'ContentFilters.AntispamService', 'type'=>'hidden'),

            'ContentFiltersAntispamService.value'=>array(
                'options'=>Configure::read('Picklist.ContentFilter.AntispamServices'), 
                'label'=>'Antispam Service'),
        ));

    echo $this->Form->inputs(array(
            'legend'=>'Akismet Settings',
            'ContentFiltersAkismetkey.id'=>array('value'=>'ContentFilters.Akismet.key', 'type'=>'hidden'),

            'ContentFiltersAkismetkey.value'=>array('label'=>'Akismet Key'),
        ));