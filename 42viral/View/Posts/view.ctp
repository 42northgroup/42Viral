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
if($mine):
    $additional = array(
        array(
            'text' => 'Edit',
            'url' => "/contents/post_edit/{$post['Post']['id']}",
            'options'=>array(),
            'confirm'=>null
        ),
        array(
            'text' => 'Delete',
            'url' => "/contents/post_delete/{$post['Post']['id']}",
            'options'=>array(),
            'confirm'=>Configure::read('System.purge_warning')
        )                
    );
else:
     $additional  = array();
endif; 

echo $this->element('Navigation' . DS . 'local', array('section'=>'content', 'additional'=>$additional));

?>

<style type="text/css">    
    .post h1{
        padding:0; 
        margin:0;
    }
    
    .post-body{
        margin-top: 6px;
    }
    
    .meta{
        font-style: italic;
        color:#999;
    }
    
    .meta-head{
        font-style: normal;
        font-weight: bold;
    }
</style>

<div class="post clearfix">

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