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
 * UI for creating a new profile company
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Zubin Khavarian <zubin.khavarian@42viral.org>
 */

    $this->Asset->addAssets(array(
        'js/vendors/ckeditor/adapters/42viral.js',
        'js/vendors/ckeditor/ckeditor.js',
        'js/vendors/ckeditor/adapters/jquery.js'
    ), 'ck_editor');

    echo $this->Asset->buildAssets('js', 'ck_editor', false);
    
    echo $this->element('Navigation' . DS . 'local', array('section'=>'company'));
    
?>

<div class="company-create-form clearfix">
    <?php
        echo $this->Form->create('ProfileCompany', array(
            'url' => '/profile_companies/save/goto:edit',
            'class'=> 'content'
        ));

        echo $this->Form->input('ProfileCompany.name');
        //No, provide a form for creating the first address
        echo $this->Form->input("Address.0.model",array('type'=>'hidden', 'value'=>'ProfileCompany'));
        echo $this->Form->input("Address.0.zip", array('style'=>'width: 70px;'));
     
        echo $this->Form->submit('Save');
        echo $this->Form->end();
    ?>
    
</div>