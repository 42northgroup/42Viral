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
//Provides a humanan readable section label
$label = '';

//Provides an array of meta ata for building menus
$menu = array();

//Configure menus

switch($section){   
    
    case 'profile':
        $menu = array(
            'Items'=>array(    
                array(
                    'text' =>__('Profile'),
                    'url' => $userProfile['Person']['url'],
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('view')
                ),                 
                array(
                    'text' => __('Images'),
                    'url' => "/uploads/images/{$userProfile['Person']['username']}/",
                    'options'=>array(),
                    'confirm'=>null
                )                
            )
        );                
    break;

    case 'manage_profile':
        
        $username = $this->Session->read('Auth.User.username');
        $profileId = $this->Session->read('Auth.User.Profile.id');
        $personId = $this->Session->read('Auth.User.id');
        
        $label = 'Manage Your Profile';
        $menu = array(
            'Items'=>array(    
                array(
                    'text' => __('Your Images'),
                    'url' => "/uploads/images/{$username}/",
                    'options'=>array(),
                    'confirm'=>null
                ),                 
                array(
                    'text' => __('Your Social Networks'),
                    'url' => "/social_networks/index/{$profileId}/",
                    'options'=>array(),
                    'confirm'=>null
                ),   
                array(
                    'text' => __('Your Addresses'),
                    'url' => "/addresses/index/{$personId}/",
                    'options'=>array(),
                    'confirm'=>null
                )            
            )
        );
        
    break;

    case 'social_network':
        
        $socialNetworkId = isset($this->data['SocialNetwork']['id'])?$this->data['SocialNetwork']['id']:null;
        $userId = $this->Session->read('Auth.User.id');
        
        $label = 'Social Networks';
        $menu = array(
            'Items'=>array(    
                array(
                    'text' => __('Your Social Networks'),
                    'url' => "/social_networks/index/{$userId}",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('index')
                ),    
                array(
                    'text' => __('Add a Social Network'),
                    'url' => "/social_networks/create/{$userId}",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('add')

                ),    
                array(
                    'text' => __('Edit this Social Network'),
                    'url' => "/social_networks/edit/{$socialNetworkId}",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions'=>array()
                          
                ),
                array(
                    'text' => __('Delete this Social Network'),
                    'url' => "/social_networks/delete/{$socialNetworkId}",
                    'options'=>array(),
                    'confirm'=>Configure::read('System.purge_warning'),
                    'actions'=>array('edit')
                ) 
            )
        );
        
    break;
    
    default:
        $label = Inflector::humanize($section);
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
    <?php echo isset($label)?$this->Html->tag('h4', $label):null; ?>
    <div class="navigation-block block-links">
        <?php 
        if(count($menu['Items']) > 0):

            //Loop through this sections menu items
            foreach($menu['Items'] as $item):

                //Removes all items that are not allowed for; or specified for this section. Lack of an actions or 
                // actions_exclude array assume all actions to be allowed.
                if(isset($item['actions'])):
                    if(!in_array($this->params['action'], $item['actions'])):
                        unset($item);
                    endif; 
                endif;

                if(isset($item['actions_exclude'])):
                    if(in_array($this->params['action'], $item['actions_exclude'])):
                        unset($item);
                    endif; 
                endif;
                
                //
                if(isset($item)):
                    echo $this->Html->link($item['text'], $item['url'], $item['options'], $item['confirm']);
                endif;

            endforeach;

        endif; 
        ?>
    </div>
</div>