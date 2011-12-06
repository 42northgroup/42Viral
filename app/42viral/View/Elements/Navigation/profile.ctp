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
    
    case 'profile':
        $menu = array(
            'name'=>'Profile',
            'Items' => array()
        );
    break;    
}

if(isset($additional)){
    $menu['Items'] = array_merge($menu['Items'], $additional);
}

?>


<div id ="ProfileManager" class="clearfix profile-navigation">

    <?php 
    
        if(isset($userProfile)):

            echo $this->Html->link('Profile', $userProfile['Person']['url']);
            echo ' / ';
            echo $this->Html->link('Content', "/contents/content/{$userProfile['Person']['username']}");
            echo ' / ';
            echo $this->Html->link('Blogs', "/blogs/index/{$userProfile['Person']['username']}");           
            echo ' / ';            
            echo $this->Html->link('Photos', "/uploads/images/{$userProfile['Person']['username']}");
            echo ' / ';
            echo $this->Html->link('Companies', "/profile_companies/index/{$userProfile['Person']['username']}");
        else:
            echo '&nbsp;';
        endif; 
    ?> 
    <div style ="position:relative; float:right;">
        <?php if(count($menu['Items']) > 0): ?>
        
            <?php echo $this->Html->link('&#9660;', '#', 
                    array('id'=>'Profile', 'class'=>'profile-navigation-link', 'escape'=>false)); ?>

            <div id="ProfileBlock" class="profile-navigation-block">
                <?php foreach($menu['Items'] as $item): ?>
                    <?php echo $this->Html->link($item['text'], $item['url'], $item['options'], $item['confirm']); ?>
                <?php endforeach; ?>
            </div>
        
        <?php //else: ?>
            <?php //echo '&#9660;'; ?>
        <?php endif; ?>
    </div>
    
</div>
