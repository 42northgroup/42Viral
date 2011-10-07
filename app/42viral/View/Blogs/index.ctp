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

<div id="ResultsPage">
    
    <?php  
    if($showAll):
        
        $nothing = empty($blogs)?true:false;
        if(!$nothing):
            
            foreach($blogs as $blog): ?>

            <div class="result">
                <h2><?php echo $this->Html->link($blog['Blog']['title'], $blog['Blog']['url']); ?></h2>
                <div class="tease"><?php echo $blog['Blog']['tease']; ?></div>
            </div>
            <?php 
            endforeach;
            
        else:    
            echo __('Their are no blogs to display');
        endif;
        
    else:
        
        $nothing = empty($blogs['Blog'])?true:false;
        
        if(!$nothing):
            
            foreach($blogs['Blog'] as $blog): 
            ?>
            <div class="result">
                <h2><?php echo $this->Html->link($blog['title'], $blog['url']); ?></h2>
                <div class="tease"><?php echo $blog['tease']; ?></div>
            </div>
            <?php 
            endforeach;
            
        else:    
            echo __("This user hasn't created any blogs");
        endif;
        
    endif; 
    
    ?>    
</div>