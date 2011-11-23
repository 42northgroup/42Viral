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
?>



<div id="Banner" class="clearfix">

    <div id="BannerLeft" class="display-name">
        <?php 
            if(isset($userProfile)):
                echo $this->Member->displayName($userProfile['Person']);
            else:
                echo '&nbsp;';
            endif; 
        ?> 
    </div>

    <div id="BannerContent">
    <?php 
        $mine = isset($mine)?$mine:false;
        if($mine){
            
            $profileId = !empty($userProfile['Person']['Profile']) ? 
                    $userProfile['Person']['Profile']['id'] : $userProfile['Profile']['id'];
            
            $additional = array(
                array(
                    'text'=>"Edit Profile",
                    'url'=>"/profiles/edit/{$profileId}",
                    'options' => array(),
                    'confirm'=>null
                )
            );
        }else{
            $additional = array();
        }

        echo $this->element('Navigation' . DS . 'profile', array('section'=>'profile', 'additional'=>$additional)); 
    ?>
    </div>

    <div id="BannerRight">
        <?php 
        //Temporary placeholder for future search functionality
        ///echo $this->Html->link('Search', '/searches/advanced');
        echo $this->Form->create('Content', array(
            'url' => '/searches/index',
            'class'=>'search',
            'style'=>"border-bottom: 1px solid #EFEFEF; padding: 1px; margin: 0 0 6px; position:relative;"
            ));

        echo $this->Form->input('q', 
                array('style'=>'width: 130px; margin:2px 0 0; padding: 4px 20px 4px 4px', 
                    'type'=>'text', 'label'=>false));

        echo $this->Form->submit(
                'graphics/icons/solid-white/16/magnifying-glass16.png',
                    array(
                        'style'=>'background: #e2e2e2; border-radius: 2px; margin:0; position:absolute; '
                        . 'padding: 2px 0 2px 2px; right: 7px; top: 5px; border-left: 1px solid #e2e2e2;'
                    )
                );
        echo $this->Form->end();

        ?>
    </div>

</div>