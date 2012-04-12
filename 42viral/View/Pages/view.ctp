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

App::uses('Scrub', 'ContentFilters.Lib');
?>
<h1><?php echo $title_for_layout; ?></h1>
<div class="row">
    <div class="two-thirds column alpha">
        <?php
            switch($page['Page']['syntax']):
                case 'markdown':
                    //Parse the markdown to HTML
                    //Make sure clever hackers haven't found a way to turn clean markdown into evil HTML
                    echo Scrub::htmlMedia(Utility::markdown($page['Page']['body'])); 
                break;

                default:
                    echo $page['Page']['body']; 
                break;        
            endswitch;
        ?>
    </div>
    <div class="one-third column omega">
    <?php 
            //Privides navigation for manageing an asset
            if($this->Session->read('Auth.User.employee')):

                //If it's your post you'll be provided CMS links
                $additional = array(
                    array(
                        'text' => 'Edit',
                        'url' => "/admin/pages/edit/{$page['Page']['id']}",
                        'options'=>array(),
                        'confirm'=>null
                    ),
                    array(
                        'text' => 'Delete',
                        'url' => "/admin/pages/delete/{$page['Page']['id']}",
                        'options'=>array(),
                        'confirm'=>Configure::read('System.purge_warning')
                    )                
                );
                        
                echo $this->element('Navigation' . DS . 'manage', 
                            array('section'=>'page', 
                                'additional'=>$additional
                            )
                        );
            endif; 
        ?>        
    </div>
</div>