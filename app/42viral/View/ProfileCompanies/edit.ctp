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
 *** @author Jason D Snider <jason.snider@42viral.org>
 *** @author Zubin Khavarian <zubin.khavarian@42viral.org>
 */

    $this->Asset->addAssets(array(
        'js/vendors/ckeditor/adapters/42viral.js',
        'js/vendors/ckeditor/ckeditor.js',
        'js/vendors/ckeditor/adapters/jquery.js'
    ), 'ck_editor');

    echo $this->Asset->buildAssets('js', 'ck_editor', false);

    if($mine){
        $additonal = array(
            array(
                'text'=>"View {$this->data['ProfileCompany']['name']}",
                'url'=>$this->data['ProfileCompany']['public_url'],
                'options' => array(),
                'confirm'=>null
            ),
            array(
                'text'=>"Delete {$this->data['ProfileCompany']['name']}",
                'url'=>$this->data['ProfileCompany']['delete_url'],
                'options' => array(),
                'confirm'=>Configure::read('System.purge_warning')
            )
        );
    }else{
        $additional = array();
    }
    
    
    echo $this->element('Navigation' . DS . 'local', array('section'=>'company', 'additional' => $additonal));

?>


    <?php 
    /*
        if($mine):
            echo $this->Html->link('Delete', $this->data['ProfileCompany']['delete_url'],
                    null, 
                    Configure::read('System.purge_warning'));
        endif; 
     
     */
    ?>


<div class="company-create-form clearfix">
    <?php
    echo $this->Form->create('ProfileCompany', array(
        'action' => 'save',
        'class'=> 'content'
    ));
    echo $this->Form->input('ProfileCompany.id');
    echo $this->Form->input('ProfileCompany.name');
    
    echo $this->Form->input('ProfileCompany.tease',
    	array(
    	    'label'=>array( 
    	    	'title'=>'How much can you say about your company in 140 characters?',
    	    	'class'=>'help'
    	    ), 
    		'type'=>'textarea', 
    		'rows'=>2
    ));
    
    echo $this->Form->input('ProfileCompany.body', array('class'=>'edit-content'));
    ?>

    <h3>Addresses:</h3>
    <?php
    if(!empty($this->data['Address'])):
        
        for($i=0; $i<count($this->data['Address']); $i++):
            echo $this->Form->input("Address.{$i}.id");
            echo $this->Form->input("Address.{$i}.line1");
            echo $this->Form->input("Address.{$i}.line2");
            echo $this->Form->input("Address.{$i}.city");
            
            echo $this->Html->div('clearfix',
                $this->Form->input("Address.{$i}.state", 
                        array(
                            'div'=>array('style'=>'float:left; padding:0 12px 0 0;'),
                            'style'=>'width: 20px;')
                        )

                . $this->Form->input("Address.{$i}.zip", 
                        array(
                            'div'=>array('style'=>'float:left;'),
                            'style'=>'width: 70px;')
                        )
                    );


        endfor;

    endif;
    
    
    echo $this->Form->submit('Save');
    echo $this->Form->end();    
    ?>
</div>