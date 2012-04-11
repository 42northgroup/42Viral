<?php 
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