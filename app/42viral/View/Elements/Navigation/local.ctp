<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake.libs.view.templates.pages
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * UI for creating local navigation. Local navigation is defined as navigiation the is local to a specific section of 
 * the web site or a database record.
 * 
 * @author Jason D Snider <jason.snider@42viral.org>
 */
$menu = array();

switch($section){
    
    case 'company':
        $menu = array(
            'name'=>'Companies',
            'Items' => array(
                array(
                    'text'=>'All Companies',
                    'url'=>'/companies',
                    'options' => array(),
                    'confirm'=>null
                ),
                
                array(
                    'text'=>'Create a Company',
                    'url'=>'/companies/create',
                    'options' => array(),
                    'confirm'=>null
                )
            )
        );
    break;    

    case 'people':
        $menu = array(
            'name'=>'People',
            'Items'=>array(
                array(
                    'text'=>'All People',
                    'url'=>'/admin/people',
                    'options' => array(),
                    'confirm'=>null
                )                
            )

        );
    break;

    case 'blog':
        

        $menu = array(
            'name'=>'Blog',
            'Items'=>array(
                array(
                    'text'=>'All Blogs',
                    'url'=>'/blogs',
                    'options' => array(),
                    'confirm'=>null
                )                
            )
        );
        
    break;

    case 'content':
        $menu = array(
            'name'=>'Content',
            'Items'=>array(
                array(
                    'text'=>'All Pages',
                    'url'=>'/pages',
                    'options' => array(),
                    'confirm'=>null
                ),        
                array(
                    'text'=>'All Blogs',
                    'url'=>'/blogs',
                    'options' => array(),
                    'confirm'=>null
                ), 
                array(
                    'text'=>'Create a Page',
                    'url'=>'/contents/page_create',
                    'options' => array(),
                    'confirm'=>null
                ), 
                array(
                    'text'=>'Create a Blog',
                    'url'=>'/contents/blog_create',
                    'options' => array(),
                    'confirm'=>null
                ),
                array(
                    'text'=>'Post to a Blog',
                    'url'=>'/contents/post_create',
                    'options' => array(),
                    'confirm'=>null
                ),                
            )
        );
    break;
}

if(isset($additional)){
    $menu['Items'] = array_merge($menu['Items'], $additional);
}

?>


<div id ="SectionManager" class="clearfix local-navigation">
    
    <h1 style="float:left; font-size: 100%; font-weight: normal;">
        <?php 
            // DO NOT!!! do an isset check here to supress errors. If their is an error finding the title, resolve it at
            // the controller level by using $this->set('title_for_layout') this will help assure page title are being 
            // set.
            echo $title_for_layout; 
        ?>
    </h1>
    
    <div style ="position:relative; float:right;">
        <?php if(count($menu['Items']) > 0): ?>
        
            <?php echo $this->Html->link('&#9660;', '#', 
                    array('id'=>'Manage', 'class'=>'section-navigation-link', 'escape'=>false)); ?>

            <div id="ManageBlock" class="section-navigation-block">
                <?php foreach($menu['Items'] as $item): ?>
                    <?php echo $this->Html->link($item['text'], $item['url'], $item['options'], $item['confirm']); ?>
                <?php endforeach; ?>
            </div>
        
        <?php else: ?>
            <?php echo $menu['name']; ?>
        <?php endif; ?>
    </div>
    
</div>