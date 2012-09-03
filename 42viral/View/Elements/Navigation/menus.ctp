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

//Provides an array of meta data for building menus
$menu = array();

//initialize an array of items comming in from a plugin
$pluginItems = array();

//Configure menus

switch($section){

    case 'profile':

        $userId = $this->Session->read('Auth.User.id');
        $personId = $menuPerson['Person']['id'];

        $menu = array(
            'label' => null,
            'Items'=>array(
                //If it's your profile and you have been authed, we will give you an edit button
                array(
                    'text'=>"Edit My Profile",
                    'url'=>"/profiles/edit/{$profileId}",
                    'options' => array(),
                    'confirm'=>null,
                    'session_check'=>"Auth.User.id:{$userId}",
                    'inactive'=>($personId == $userId)?false:true
                ),
                array(
                    'text' =>__('Profile'),
                    'url' => $menuPerson['Person']['url'],
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('profiles:view')
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
                )
            )
        );

    break;

    case 'manage_profile':

        $username = $this->Session->read('Auth.User.username');
        $personId = $this->Session->read('Auth.User.id');

        $menu = array(
            'label' => 'My Account',
            'Items'=>array(
                array(
                    'text' => __('Content'),
                    'url' => "/contents/mine/",
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

    	$menu = array(
    	    'label' => 'Addresses',
    		'Items'=>array(
    			array(
    				'text' => __('Your Addresses'),
    				'url' => "/addresses/index/person/{$personId}/",
    				'options'=>array(),
    				'confirm'=>null,
    				'actions_exclude'=>array('profiles:index')
    			),
    			array(
    				'text' => __('Create an Address'),
    				'url' => "/addresses/create/person/{$personId}/",
    				'options'=>array(),
    				'confirm'=>null,
    				'actions_exclude'=>array('profiles:create')
    				),
    			array(
    				'text' => __('Delete this Address'),
    				'url' => "/addresses/delete/{$addressId}/person/{$personId}/",
    				'options'=>array(),
    				'confirm'=>null,
    				'actions'=>array(
    				    'profiles:view',
    				    'profiles:edit'
				    )
    			)
    		)
    	);
    	break;

    case 'social_network':

        $socialNetworkId = isset($this->data['SocialNetwork']['id'])?$this->data['SocialNetwork']['id']:null;
        $userId = $this->Session->read('Auth.User.id');

        $menu = array(
            'label' => 'Social Networks',
            'Items'=>array(
                array(
                    'text' => __('Your Social Networks'),
                    'url' => "/social_networks/index/person/{$userId}/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array(
                        'social_networks:index'
                    )
                ),
                array(
                    'text' => __('Add a Social Network'),
                    'url' => "/social_networks/create/person/{$userId}/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('social_networks:create')

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
                    'actions'=>array('social_networks:edit')
                )
            )
        );

    break;
    case 'phone_number':

        $phoneNumberId = isset($this->data['PhoneNumber']['id'])?$this->data['PhoneNumber']['id']:null;
        $userId = $this->Session->read('Auth.User.id');

        $menu = array(
            'label' => 'Phone Numbers',
            'Items'=>array(
                array(
                    'text' => __('Your Phone Numbers'),
                    'url' => "/phone_numbers/index/person/{$userId}/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('phone_numbers:index')
                ),
                array(
                    'text' => __('Add a Phone Number'),
                    'url' => "/phone_numbers/create/person/{$userId}/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('phone_numbers:add')
                ),
                array(
                    'text' => __('Delete this Phone Number'),
                    'url' => "/phone_numbers/delete/{$phoneNumberId}/person/{$userId}/",
                    'options'=>array(),
                    'confirm'=>Configure::read('System.purge_warning'),
                    'actions'=>array('phone_numbers:edit')
                )
            )
        );

    break;
    case 'email_address':

        $emailAddressId = isset($this->data['EmailAddress']['id'])?$this->data['EmailAddress']['id']:null;
        $userId = $this->Session->read('Auth.User.id');

        $menu = array(
            'label' => 'Email Addresses',
            'Items'=>array(
                array(
                    'text' => __('Your Email Addresses'),
                    'url' => "/email_addresses/index/person/{$userId}/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('email_addresses:index')
                    ),
                array(
                    'text' => __('Add an Email Address'),
                    'url' => "/email_addresses/create/person/{$userId}/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('email_addresses:create')
                ),
                array(
                    'text' => __('Delete this mail Address'),
                    'url' => "/email_addresses/delete/{$emailAddressId}/person/{$userId}/",
                    'options'=>array(),
                    'confirm'=>Configure::read('System.purge_warning'),
                    'actions'=>array('email_addresses:edit')
                )
            )
        );
    break;

    case 'user_setting':

        $personId = $this->Session->read('Auth.User.id');
        $profileId = $this->Session->read('Auth.User.Profile.id');

        $menu = array(
            'label' => 'Settings',
            'Items'=>array(
                array(
                    'text' => __('Settings'),
                    'url' => "/user_settings/index/person/{$personId}/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('user_settings:index')
                ),
                array(
                    'text' => __('Change Password'),
                    'url' => "/users/change_password/person/{$personId}/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('user_settings:change_password')
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

    case 'admin':
        if($this->Session->read('Auth.User.employee') == 1):
            $personId = $this->Session->read('Auth.User.id');
            $menu = array(
                'label'=>'Admin',
                'Items'=>array(
                    array(
                        'text' =>__('Users'),
                        'url' => "/admin/users/",
                        'options'=>array(),
                        'confirm'=>null,
                        'actions_exclude'=>array(),
                        //'session_check'=>'Auth.User.employee:1'
                    ),
                    array(
                        'text' =>__('Groups'),
                        'url' => "/admin/users/acl_groups/",
                        'options'=>array(),
                        'confirm'=>null,
                        'actions_exclude'=>array(),
                        //'session_check'=>'Auth.User.employee:1'
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
                        //'session_check'=>'Auth.User.employee:1'
                    ),
                )
            );
        else:
            $menu = array(
                'label' => null,
                'Items'=>array()
            );
        endif;

    break;

    default:

        $menu = array(
            'label' => Inflector::humanize($section),
            'Items'=>array()
        );
    break;
}

//Add any additional items to the menu array
if(isset($additional)){
    $menu['Items'] = array_merge($menu['Items'], $additional);
}

//Do any plugins want to use the navigation?
$pluginMenuElementPath = 'View' . DS . 'Elements' . DS . 'menu_injection.ctp';
foreach(App::path('Plugin') as $pluginPath){
    foreach(scandir($pluginPath) as $plugin){
        if(is_file($pluginPath . $plugin . DS . $pluginMenuElementPath)){
            $pluginVars = unserialize($this->element("{$plugin}.menu_injection",array('section'=>$section)));

            foreach($pluginVars['pluginItems'] as $pluginItem){
                $pluginItems[] = $pluginItem;
            }
        }
    }
}

if(!empty($pluginItems)){
    $menu['Items'] = array_merge($menu['Items'], $pluginItems);
}

echo $this->Menu->side($menu);