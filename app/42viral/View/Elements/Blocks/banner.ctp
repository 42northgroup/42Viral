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

<<<<<<< HEAD
=======
<?php if(isset($userProfile)): ?>
    <div id="Banner" class="clearfix">

        <div id="BannerLeft" class="display-name">
            <?php echo $this->Member->displayName($userProfile['Person']); ?>
        </div>

        <div id="BannerContent">
        <?php 
            if($mine){
                $additional = array(
                    array(
                        'text'=>"Edit Profile",
                        'url'=>"/profiles/edit/{$userProfile['Person']['id']}",
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
>>>>>>> reintroduced banner navigation, tweaked local nav

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
            $additional = array(
                array(
                    'text'=>"Edit Profile",
                    'url'=>"/profiles/edit/{$userProfile['Person']['Profile']['id']}",
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
<<<<<<< HEAD
    
    <div id="BannerRight">
        <?php 
            //Temporary placeholder for future search functionality
            echo $this->Html->link('Search', "javascript:alert('Comming Soon!')");
        ?>
    </div>

</div>
=======
<?php endif; ?>
>>>>>>> reintroduced banner navigation, tweaked local nav
