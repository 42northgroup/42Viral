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
 * UI for creating a web page
 * @author Jason D Snider <jason.snider@42viral.org>
 */

echo $this->element('Navigation' . DS . 'local', array('section'=>'blog'));

?>

<style type="text/css">
    .post-avatar{
        float:left; padding:8px 0 0; height:128px; width:138px;
    }
    
    .post h1{
        padding:0; 
        margin:0;
    }
    
    .post-body{
        margin-top: 6px;
    }
    
    .meta{
        font-style: italic;
        color:#555;
    }
    
    .meta-head{
        font-style: normal;
        font-weight: bold;
    }
</style>

<div class="clearfix">
    
    <h1 style="float:left;"><?php echo $post['Post']['title']; ?></h1>
    
    <div style="float:right; margin:6px 0 0;">
        <?php
            if($mine):
                echo $this->Html->link('Edit', "/contents/post_edit/{$post['Post']['id']}");
                echo ' / ';
                echo $this->Html->link('Delete', "/contents/post_delete/{$post['Post']['id']}", null,
                        Configure::read('System.purge_warning'));
            endif; 
        ?>
    </div>
    
</div>

<div class="post clearfix">
    <div class="meta">
        <span class="meta-head">Posted:</span>
        <?php echo $this->Member->displayName($post['CreatedPerson']); ?>
        &nbsp;<?php echo $post['Post']['created']; ?>

    </div>
    <div class="post-body">
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
    </div>
</div>

<div class="meta" style="margin: 6px 0;">
    <span class="meta-head">Last Modified:</span>
    <?php echo $post['Post']['modified']; ?>
</div>

<?php foreach($post['Conversation'] as $conversation): ?>
    <div><?php echo $conversation['body']; ?></div>
<?php endforeach; ?>

<?php echo $this->element('Posts' . DS . 'post_comments'); ?>