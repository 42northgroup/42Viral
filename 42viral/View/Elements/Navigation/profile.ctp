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
?>
<div class="column-block">
    <div class="navigation-block">
        <?php 
            if(isset($userProfile)):

                echo $this->Html->link('Profile', $userProfile['Person']['url']);
                echo $this->Html->link('Content', "/contents/content/{$userProfile['Person']['username']}");
                echo $this->Html->link('Blogs', "/blogs/index/{$userProfile['Person']['username']}");                  
                echo $this->Html->link('Photos', "/uploads/images/{$userProfile['Person']['username']}");
            else:
                echo '&nbsp;';
            endif; 
        ?> 
    </div>

    <?php
    $mine = isset($mine)?$mine:false; 
    $section = isset($section)?$section:'profile';

    if($mine){

        $profileId = !empty($userProfile['Person']['Profile']) ? 
                $userProfile['Person']['Profile']['id'] : $userProfile['Profile']['id'];

        $additional = array(
            array(
                'text'=>"Edit Profile",
                'url'=>"/profiles/edit/{$profileId}",
                'options' => array(),
                'confirm'=>null
            )
        );
    }else{
        $additional = array();
    }

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
    <?php if(count($menu['Items']) > 0): ?>
        <div>
            <?php foreach($menu['Items'] as $item): ?>
                <?php echo $this->Html->link($item['text'], $item['url'], $item['options'], $item['confirm']); ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

