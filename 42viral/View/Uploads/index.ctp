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
?>
<h1><?php echo $title_for_layout; ?></h1>

<div class="row">
    <div class="two-thirds column alpha">
    <?php if(empty($uploads)): ?>
        <div class="no-results">
            <div class="no-results-message">
                <?php echo __("I'm sorry, there are no results to display."); ?>
            </div>
        </div>
    <?php else: ?>
        <?php foreach($uploads as $upload): ?>
            <div class="image-frame" style="margin: 0 4px 6px 0">
                <?php
                if($upload['Upload']['object_type'] == 'image'):
                    echo $this->Html->image(
                            $upload['Upload']['thumbnail_image_uri'],
                            array(
                                'url'=>$upload['Upload']['uri']
                            )
                    )."<br/>";

                    if($upload['Upload']['avatar'] == 0):
                        echo $this->Html->link('Set as Avatar', "/uploads/make_avatar/".$upload['Upload']['model']
                                                                                    ."/".$upload['Upload']['model_id']
                                                                                    ."/".$upload['Upload']['id']);
                    else:
                        echo "Avatar";
                    endif;
                else:
                    echo $this->Html->link(
                            __('No Document Preview'),
                            $upload['Upload']['uri'],
                            array(
                                'style'=>'display:inline-block; height:125px; width:125px;'
                            )
                        );
                endif;
                ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    </div>
    <div class="one-third column omega">
        <?php echo $this->element('Navigation' . DS . 'menus', array('section'=>'upload')); ?>
    </div>
</div>