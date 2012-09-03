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
    'legend'=>'Theme Settings',

    'Themeset.id'=>array('value'=>'Theme.set', 'type'=>'hidden'),
    'Themeset.value'=>array(
        'label'=>'Theme Set',
        'value'=> empty($this->data['Themeset'][''])?'Default':$this->data['Themeset'][''],
        'div'=>array('class'=>'input required')
    ),

    'ThemeHomePagetitle.id'=>array('value'=>'Theme.HomePage.title', 'type'=>'hidden'),
    'ThemeHomePagetitle.value'=>array(
        'label'=>'Home Page Title',
        'div'=>array('class'=>'input required')
    ),

));