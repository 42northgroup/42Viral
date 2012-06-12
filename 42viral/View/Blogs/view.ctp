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
        <div>
            <?php 
            switch($blog['Blog']['syntax']):
                case 'markdown':
                    //Parse the markdown to HTML
                    //Make sure clever hackers haven't found a way to turn clean markdown into evil HTML
                    echo Scrub::htmlMedia(Utility::markdown($blog['Blog']['body'])); 
                break;

                default:
                    echo $blog['Blog']['body']; 
                break;        
            endswitch;
            ?>
        </div>

        <div id="ResultsPage">
            <?php foreach($posts as $post): ?>
                <div class="result">
                    <div class="result-left">
                        <?php echo Inflector::humanize($post['Post']['object_type']); ?>
                    </div>
                    <div class="result-right">

                        <strong><?php echo $this->Html->link($post['Post']['title'], 
                                $post['Post']['url']); ?> </strong>

                        <div class="tease">
                            <?php 
                            switch($post['Post']['syntax']):
                                case 'markdown':
                                    //echo Scrub::htmlMedia(
                                    echo Scrub::noHtml(
                                            Utility::markdown(
                                                $this->Text->truncate(
                                                        $post['Post']['body'], 180, array('html' => true))));                                      
                                break;

                                default:
                                    echo Scrub::noHtml(
                                        $this->Text->truncate(
                                                $post['Post']['body'], 180, array('html' => true)));  
                                break;        
                            endswitch;
                            ?> 
                        </div>
                    </div>
                </div>  
            <?php endforeach; ?>
        </div>
        <?php echo $this->element('paginate'); ?>
    </div>
    <div class="one-third column omega">
    <?php 

            //Privides navigation for manageing an asset
            if($mine):

                //If it's your post you'll be provided CMS links
                $additional = array(
                    array(
                        'text' => 'Edit',
                        'url' => "/blogs/edit/{$blog['Blog']['id']}",
                        'options'=>array(),
                        'confirm'=>null
                    ),
                    array(
                        'text' => 'Delete',
                        'url' => "/blogs/delete/{$blog['Blog']['id']}",
                        'options'=>array(),
                        'confirm'=>Configure::read('System.purge_warning')
                    )                
                );
                        
                echo $this->element('Navigation' . DS . 'menus', 
                            array('section'=>'post', 
                                'additional'=>$additional
                            )
                        );
            endif; 

        ?>        
    </div>
</div>