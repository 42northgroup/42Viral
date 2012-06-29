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
                    'url' => $menuPerson['Person']['url'],
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('view')
                ),
                array(
                    'text' => __('Uploads'),
                    'url' => "/uploads/index/person/{$menuPerson['Person']['id']}/",
                    'options'=>array(),
                    'confirm'=>null
                )
            )
        );
    break;

    case 'manage_profile':

        $username = $this->Session->read('Auth.User.username');
        $personId = $this->Session->read('Auth.User.id');

        $label = 'My Account';
        $menu = array(
            'Items'=>array(
                array(
                    'text' => __('Content'),
                    'url' => "/contents/mine/",
                    'options'=>array(),
                    'confirm'=>null
                ),
                array(
                    'text' => __('Uploads'),
                    'url' => "/uploads/index/person/{$personId}/",
                    'options'=>array(),
                    'confirm'=>null
                ),
                array(
                    'text' => __('Social Networks'),
                    'url' => "/social_networks/index/person/{$personId}/",
                    'options'=>array(),
                    'confirm'=>null
                ),
                array(
                    'text' => __('Addresses'),
                    'url' => "/addresses/index/person/{$personId}/",
                    'options'=>array(),
                    'confirm'=>null
                ),
                array(
                    'text' => __('Email Addresses'),
                    'url' => "/email_addresses/index/person/{$personId}/",
                    'options'=>array(),
                    'confirm'=>null
                ),
                array(
                    'text' => __('Phone Numbers'),
                    'url' => "/phone_numbers/index/person/{$personId}/",
                    'options'=>array(),
                    'confirm'=>null
                ),
                array(
                    'text' => __('Connect'),
                    'url' => "/oauth/connect/",
                    'options'=>array(),
                    'confirm'=>null
                    ),
                array(
                    'text' => __('Settings'),
                    'url' => "/user_settings/index/person/{$personId}/",
                    'options'=>array(),
                    'confirm'=>null
                )
            )
        );

    break;

    case 'address':

    	$addressId = isset($this->data['Address']['id'])?$this->data['Address']['id']:null;
    	$personId = $this->Session->read('Auth.User.id');

    	$label = 'Address';
    	$menu = array(
    		'Items'=>array(
    			array(
    				'text' => __('Your Addresses'),
    				'url' => "/addresses/index/person/{$personId}/",
    				'options'=>array(),
    				'confirm'=>null,
    				'actions_exclude'=>array('index')
    			),
    			array(
    				'text' => __('Create an Address'),
    				'url' => "/addresses/create/person/{$personId}/",
    				'options'=>array(),
    				'confirm'=>null,
    				'actions_exclude'=>array('create')
    				),
    			array(
    				'text' => __('Delete this Address'),
    				'url' => "/addresses/delete/{$addressId}/person/{$personId}/",
    				'options'=>array(),
    				'confirm'=>null,
    				'actions'=>array('view', 'edit')
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
                    'url' => "/social_networks/index/person/{$userId}/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('index')
                ),
                array(
                    'text' => __('Add a Social Network'),
                    'url' => "/social_networks/create/person/{$userId}/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('create')

                ),
                array(
                    'text' => __('Edit this Social Network'),
                    'url' => "/social_networks/edit/{$socialNetworkId}/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions'=>array()

                ),
                array(
                    'text' => __('Delete this Social Network'),
                    'url' => "/social_networks/delete/{$socialNetworkId}/",
                    'options'=>array(),
                    'confirm'=>Configure::read('System.purge_warning'),
                    'actions'=>array('edit')
                )
            )
        );

    break;
    case 'phone_number':

        $phoneNumberId = isset($this->data['PhoneNumber']['id'])?$this->data['PhoneNumber']['id']:null;
        $userId = $this->Session->read('Auth.User.id');

        $label = 'Phone Numbers';
        $menu = array(
            'Items'=>array(
                array(
                    'text' => __('Your Phone Numbers'),
                    'url' => "/phone_numbers/index/person/{$userId}/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('index')
                ),
                array(
                    'text' => __('Add a Phone Number'),
                    'url' => "/phone_numbers/create/person/{$userId}/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('add')
                ),
                array(
                    'text' => __('Delete this Phone Number'),
                    'url' => "/phone_numbers/delete/{$phoneNumberId}/person/{$userId}/",
                    'options'=>array(),
                    'confirm'=>Configure::read('System.purge_warning'),
                    'actions'=>array('edit')
                )
            )
        );

    break;
    case 'email_address':

        $emailAddressId = isset($this->data['EmailAddress']['id'])?$this->data['EmailAddress']['id']:null;
        $userId = $this->Session->read('Auth.User.id');

        $label = 'Email Addresses';
        $menu = array(
            'Items'=>array(
                array(
                    'text' => __('Your Email Addresses'),
                    'url' => "/email_addresses/index/person/{$userId}/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('index')
                    ),
                array(
                    'text' => __('Add an Email Address'),
                    'url' => "/email_addresses/create/person/{$userId}/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('create')
                ),
                array(
                    'text' => __('Delete this mail Address'),
                    'url' => "/email_addresses/delete/{$emailAddressId}/person/{$userId}/",
                    'options'=>array(),
                    'confirm'=>Configure::read('System.purge_warning'),
                    'actions'=>array('edit')
                )
            )
        );
    case 'user_setting':

        $personId = $this->Session->read('Auth.User.id');
        $profileId = $this->Session->read('Auth.User.Profile.id');

        $label = 'Settings';
        $menu = array(
            'Items'=>array(
                array(
                    'text' => __('Settings'),
                    'url' => "/user_settings/index/person/{$personId}/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('index')
                ),
                array(
                    'text' => __('Change Password'),
                    'url' => "/users/change_password/person/{$personId}/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('change_password')
                ),
                array(
                    'text' => __('Edit Profile'),
                    'url' => "/profiles/edit/{$profileId}/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array()
                ),
            )
        );

    break;
    case 'upload':

        $personId = $this->Session->read('Auth.User.id');

        $label = 'Uploads';
        $menu = array(
            'Items'=>array(
                array(
                    'text' => __('Your Uploads'),
                    'url' => "/uploads/index/person/{$personId}/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('index')
                ),
                array(
                    'text' => __('Upload a File'),
                    'url' => "/uploads/create/person/{$personId}/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('create')
                ),
            )
        );

    break;

    case 'page':
        $pageId = isset($page['Page']['id'])?$page['Page']['id']:null;
        $label = 'Page';
        $menu = array(
            'Items'=>array(
                array(
                    'text' => __('Pages'),
                    'url' => "/pages/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('index')
                ),
                array(
                    'text' => __('Pages (Admin View)'),
                    'url' => "/admin/pages/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('admin_index'),
                    'session_check'=>'Auth.User.employee:1'
                ),
                array(
                    'text' => __('Create a new page'),
                    'url' => "/admin/pages/create/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('admin_edit'),
                    'session_check'=>'Auth.User.employee:1'
                ),
                array(
                    'text' => __('Edit this page'),
                    'url' => "/admin/pages/edit/{$pageId}/",
                    'options'=>array(),
                    'actions_exclude'=>array('index', 'admin_create', 'admin_edit', 'admin_index'),
                    'confirm'=>null,
                    'session_check'=>'Auth.User.employee:1'
                ),
                array(
                    'text' => __('Delete this page'),
                    'url' => "/admin/pages/delete/{$pageId}/",
                    'options'=>array(),
                    'confirm'=>Configure::read('System.purge_warning'),
                    'actions'=>array('view', 'admin_edit'),
                    'session_check'=>'Auth.User.employee:1'
                )
            )
        );
    break;

    case 'admin':
        if($this->Session->read('Auth.User.employee') == 1):
            $personId = $this->Session->read('Auth.User.id');

            $label = 'Admin';
            $menu = array(
                'Items'=>array(
                    array(
                        'text' =>__('Create a web page'),
                        'url' => "/admin/pages/create/",
                        'options'=>array(),
                        'confirm'=>null,
                        'actions_exclude'=>array(),
                        'session_check'=>'Auth.User.employee:1'
                    ),
                    array(
                        'text' =>__('Pages'),
                        'url' => "/pages/",
                        'options'=>array(),
                        'confirm'=>null,
                        'actions_exclude'=>array(),
                        'session_check'=>'Auth.User.employee:1'
                    ),
                    array(
                        'text' =>__('People'),
                        'url' => "/admin/people/",
                        'options'=>array(),
                        'confirm'=>null,
                        'actions_exclude'=>array(),
                        'session_check'=>'Auth.User.employee:1'
                    ),
                    array(
                        'text' =>__('Users'),
                        'url' => "/admin/users/",
                        'options'=>array(),
                        'confirm'=>null,
                        'actions_exclude'=>array(),
                        'session_check'=>'Auth.User.employee:1'
                    ),
                    array(
                        'text' =>__('Groups'),
                        'url' => "/admin/users/acl_groups/",
                        'options'=>array(),
                        'confirm'=>null,
                        'actions_exclude'=>array(),
                        'session_check'=>'Auth.User.employee:1'
                    ),
                    array(
                        'text' =>__('Configuration'),
                        'url' => "/admin/configurations/",
                        'options'=>array(),
                        'confirm'=>null,
                        'actions_exclude'=>array(),
                        'session_check'=>'Auth.User.employee:1'
                    ),
                    array(
                        'text' =>__('Allot invites'),
                        'url' => "/admin/users/allot_invites/",
                        'options'=>array(),
                        'confirm'=>null,
                        'actions_exclude'=>array(),
                        //'Configure.key:value'
                        'configure_check'=>'Beta.private:1',
                        //'Session.key:value'
                        'session_check'=>'Auth.User.employee:1'
                    ),
                )
            );
        else:
            $label = null;
            $menu = array(
                'Items'=>array()
            );
        endif;

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

                //Remove any items that are listed an "Not Showable" against a target actions
                if(isset($item['actions_exclude'])):
                    if(in_array($this->params['action'], $item['actions_exclude'])):
                        unset($item);
                    endif;
                endif;

                //Check Configure values, if the session check key does not match the desired value, unset the menu item
                if(isset($item['configure_check'])):
                    $chunks = explode(':', $item['configure_check']);
                    if(Configure::read($chunks[0]) != $chunks[1]):
                        unset($item);
                    endif;
                endif;

                //Check Session values, if the session check key does not match the desired value, unset the menu item
                if(isset($item['session_check'])):
                    $chunks = explode(':', $item['session_check']);
                    if($this->Session->read($chunks[0]) != $chunks[1]):
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