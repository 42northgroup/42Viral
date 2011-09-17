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
 **** @author Jason D Snider <jason.snider@42viral.org>
 ***** @author Zubin Khavarian <zubin.khavarian@42viral.org>
 */

    $this->Asset->addAssets(array(
        'js/vendors/ckeditor/adapters/42viral.js',
        'js/vendors/ckeditor/ckeditor.js',
        'js/vendors/ckeditor/adapters/jquery.js'
    ), 'ck_editor');

    echo $this->Asset->buildAssets('js', 'ck_editor', false);
?>
<h1>Create Company Profile</h1>

<div class="company-create-form clearfix">
    <?php
        echo $this->Form->create('Company', array(
            'url' => '/companies/save/goto:edit',
            'class'=> 'content'
        ));

        echo $this->Form->input('Company.name');
           //No, provide a form for creating the first address
            echo $this->Form->input("Address.0.model",array('type'=>'hidden', 'value'=>'Company'));
            echo $this->Form->input("Address.0.zip", array('style'=>'width: 70px;'));
     
        echo $this->Form->submit('Save');
        echo $this->Form->end();
    ?>
    
</div>