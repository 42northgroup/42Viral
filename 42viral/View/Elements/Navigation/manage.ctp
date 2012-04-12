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

$menu = array();

switch($section){
    /*
    case 'post':
        

        $menu = array(
            'Items'=>array(
                array(
                    'text'=>'Blogs',
                    'url'=>'/blogs',
                    'options' => array(),
                    'confirm'=>null
                )                
            )
        );
        
    break;
    */
    default :
        $menu = array(
            'Items'=>array()             
        );
    break;
}

if(isset($additional)){
    $menu['Items'] = array_merge($menu['Items'], $additional);
}
?>

<div class="column-block">
    <h4>Manage this <?php echo $section; ?></h4>
    <div class="navigation-block">
        <?php if(count($menu['Items']) > 0): ?>

        <?php foreach($menu['Items'] as $item): ?>
            <?php echo $this->Html->link($item['text'], $item['url'], $item['options'], $item['confirm']); ?>
        <?php endforeach; ?>

        <?php endif; ?>
    </div>
</div>