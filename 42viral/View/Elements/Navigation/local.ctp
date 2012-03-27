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
            'Items'=>array(
                array(
                    'text'=>'Notifications',
                    'url'=>'/notification',
                    'options' => array(),
                    'confirm'=>null
                ),
                
                array(
                    'text'=>'Create',
                    'url'=>'/notification/create',
                    'options' => array(),
                    'confirm'=>null
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