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
 * @author Jason D Snider <jason.snider@42viral.org>
 */
?>

<h1><?php echo $title_for_layout; ?></h1>

<div class="row">
    
    <div class="two-thirds column alpha">
        <?php

            //Find some custom theme paths
            $themePath = ROOT . DS . APP_DIR . DS . 'View' . DS . 'Themed' . DS 
                    . Configure::write('Theme.set', 'Default') . DS;

            $unthemedPath = ROOT . DS . APP_DIR . DS . 'View' . DS;

            $relativeCustomPath = 'Blogs' . DS . 'Custom' . DS;

            $file = 'accessing-phpmyadmin-after-apt-get-install.ctp';


            $file = $post['Post']['custom_file'] . '.ctp';

            //Is there a custom content file to be appended here?
            if(is_file( $themePath .$relativeCustomPath . $file)){

                require($themePath .$relativeCustomPath . $file);

            }elseif(is_file( $unthemedPath .$relativeCustomPath . $file)){

                require($unthemedPath .$relativeCustomPath . $file);         

            }    
        ?>
        <?php echo $post['Post']['body']; ?>

        <div class="meta" style="margin: 6px 0;">
            <span class="meta-head">Posted:</span>
            <?php echo Handy::date($post['Post']['created']); ?>
            <span class="meta-head">Last Modified:</span>
            <?php echo Handy::date($post['Post']['modified']); ?>
        </div>

        <?php foreach($post['Conversation'] as $conversation): ?>
            <div class="result">
                <?php if(empty($conversation['email'])): ?>
                    <div class="meta">
                        <?php echo $this->Member->displayName($conversation['CreatedPerson']); ?>
                        <span class="meta-head">Posted:</span>
                        <?php echo Handy::date($conversation['created']); ?>
                    </div>
                <?php else: ?>
                    <div class="meta">
                        <?php echo $conversation['name']; ?>
                        <span class="meta-head">Posted:</span>
                        <?php echo Handy::date($conversation['created']); ?>
                    </div>
                <?php endif; ?>

                <?php echo $conversation['body']; ?>
            </div>
        <?php endforeach; ?>

        <?php echo $this->element('Posts' . DS . 'post_comments'); ?>
    </div>
    
    <div class="one-third column omega">
        <?php echo $this->element('Blocks' . DS . 'hcard', array('userProfile'=>$userProfile, 'allOpen'=>false)); ?>
        
        <?php echo $this->element('Navigation' . DS . 'profile', array('mine'=>$mine)); ?>
        
        <?php echo $this->element('Blocks' . DS . 'tag_cloud'); ?>
        
        <?php 
            //Privides navigation for manageing an asset
            if($mine):

                //If it's your post you'll be provided CMS links
                $additional = array(
                    array(
                        'text' => 'Edit',
                        'url' => "/posts/edit/{$post['Post']['id']}",
                        'options'=>array(),
                        'confirm'=>null
                    ),
                    array(
                        'text' => 'Delete',
                        'url' => "/posts/delete/{$post['Post']['id']}",
                        'options'=>array(),
                        'confirm'=>Configure::read('System.purge_warning')
                    )                
                );
                        
                echo $this->element('Navigation' . DS . 'manage', 
                            array('section'=>'post', 
                                'additional'=>$additional
                            )
                        );
            endif; 
        ?>
    </div>
    
</div>