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
    case 'blog':
        

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

    case 'cases':
        

        $menu = array(
            'Items'=>array()
        );
        
    break;

    case 'content':
        $menu = array(
            'Items'=>array()
        );
    break;

    case 'admin_people':
        $menu = array(
            'Items'=>array(
                array(
                    'text'=>'People (CRM)',
                    'url'=>'/admin/people',
                    'options' => array(),
                    'confirm'=>null
                )                
            )

        );
    break;

    case 'members':
        $menu = array(
            'Items'=>array(
                array(
                    'text'=>'Members',
                    'url'=>'/members',
                    'options' => array(),
                    'confirm'=>null
                )          
            )

        );
    break;

    case 'notifications':
        $menu = array(
            'Items' => array(
                array(
                    'text' => 'Index',
                    'url' => '/notification',
                    'options' => array(),
                    'confirm' => null
                ),
                array(
                    'text' => 'Create',
                    'url' => '/notification/create',
                    'options' => array(),
                    'confirm' => null
                )
            )
        );
        break;

    case 'acl_groups':
        $menu = array(
            'Items'=>array(
                            
                array(
                    'text'=>'ACL Groups',
                    'url'=>'/admin/users/acl_groups',
                    'options' => array(),
                    'confirm'=>null
                ),
                
                array(
                    'text'=>'New ACL Group',
                    'url'=>'/admin/users/create_acl_group',
                    'options' => array(),
                    'confirm'=>null
                )             
            )

        );
    break;

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
    <div class="navigation-block">
        <?php if(count($menu['Items']) > 0): ?>

        <?php foreach($menu['Items'] as $item): ?>
            <?php echo $this->Html->link($item['text'], $item['url'], $item['options'], $item['confirm']); ?>
        <?php endforeach; ?>

        <?php endif; ?>
    </div>
</div>