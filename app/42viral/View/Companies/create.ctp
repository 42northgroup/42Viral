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
 * @author Jason D Snider <jsnider77@gmail.com>
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
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
            'action' => 'save',
            'class'=> 'content'
        ));

        echo $this->Form->input('Company.name');
        echo $this->Form->input('Company.body', array('class'=>'edit-basic'));
    ?>

    <h3>Address:</h3>
    <?php
        echo $this->Form->input('Address.line1');
        echo $this->Form->input('Address.line2');
        echo $this->Form->input('Address.city');
        
        echo $this->Html->div('clearfix',

            $this->Form->input('Address.state', 
                    array(
                        'div'=>array('style'=>'float:left; padding:0 12px 0 0;'),
                        'style'=>'width: 20px;')
                    )

            . $this->Form->input('Address.zip', 
                    array(
                        'div'=>array('style'=>'float:left;'),
                        'style'=>'width: 70px;')
                    )
                );

        echo $this->Form->submit('Save');
        echo $this->Form->end();
    ?>
</div>