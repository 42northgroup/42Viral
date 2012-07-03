<?php
/**
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2012, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Provides a configuration array for navigation
 * @author Jason D Snider <jason.snider@42northgroup.com>
 * @package Plugin\ResumeWizard
 */
//Provides a humanan readable section label
$label = '';

//Provides an array of meta ata for building menus
$menu = array();

$section = isset($section)?$section:null;

//Configure menus

switch($section){

    case 'resume':
    default:

        $personId = $this->Session->read('Auth.User.id');

        $menu = array(
            'Items'=>array(
                array(
                    'text' =>__('Resumes'),
                    'url' => "/resume_wizard/resumes/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('index')
                ),
                array(
                    'text' =>__('Create'),
                    'url' => "/resume_wizard/resumes/create/person/{$personId}/",
                    'options'=>array(),
                    'confirm'=>null,
                    'actions_exclude'=>array('create')
                )
            )
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