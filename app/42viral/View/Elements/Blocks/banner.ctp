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

    </div>
<?php endif; ?>