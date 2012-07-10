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

App::uses('AppHelper', 'View/Helper');
/**
 * A helper for hiding unauthorized access.
 *
 * @package app
 * @subpackage app.core
 * @author Jason D Snider <jsnider77@gmail.com>
 */
class MenuHelper extends AppHelper
{

    /**
     * Helpers
     * @var array
     * @access public
     */
    public $helpers = array('Html');

    public function side($menu){

        $menuDisplay = "<div class=\"column-block\">";
        $menuDisplay .= !is_null($menu['label'])?$this->Html->tag('h4', $menu['label']):null;
            $menuDisplay .= "<div class=\"navigation-block block-links\">";

                if(count($menu['Items']) > 0):

                    //Loop through this sections menu items
                    foreach($menu['Items'] as $item):

                        //check the inactive flag
                        if(isset($item['inactive'])):
                            if($item['inactive']):
                                unset($item);
                            endif;
                        endif;

                        //Removes all items that are not allowed for; or specified for this section. Lack of an actions
                        //or actions_exclude array assume all actions to be allowed.
                        if(isset($item['actions'])):
                            $thisController = false;
                            $thisAction = false;
                            foreach($item['actions'] as $action):

                                $chunks = explode(':', $action); //controller:action

                                if($chunks[0] == $this->params['controller']): //filter the controller
                                    $thisController = true;
                                endif;

                                if($chunks[1] == $this->params['action']): //filter the action
                                    $thisAction = true;
                                endif;

                            endforeach;

                            if(!$thisController || !$thisAction){
                                unset($item);
                            }

                        endif;

                        //Remove any items that are listed an "Not Showable" against a target actions
                        if(isset($item['actions_exclude'])):

                            foreach($item['actions_exclude'] as $exclude):
                                $chunks = explode(':', $exclude); //controller:action
                                if($chunks[0] == $this->params['controller']): //filter the controller
                                    if($chunks[1] == $this->params['action'] || $chunks[1] == '*'): //filter the action
                                        unset($item);
                                    endif;
                                endif;
                            endforeach;

                        endif;

                        // Check Configure values, if the session check key does not match the desired value, unset the
                        // menu item
                        if(isset($item['configure_check'])):
                            $chunks = explode(':', $item['configure_check']);
                            if(Configure::read($chunks[0]) != $chunks[1]):
                                unset($item);
                            endif;
                        endif;

                        // Check Session values, if the session check key does not match the desired value, unset the
                        // menu item
                        if(isset($item['session_check'])):
                            $chunks = explode(':', $item['session_check']);
                            if($this->Session->read($chunks[0]) != $chunks[1]):
                                unset($item);
                            endif;
                        endif;

                        //
                        if(isset($item)):
                            $menuDisplay .= $this->Html->link(
                                $item['text'], $item['url'], $item['options'], $item['confirm']);
                        endif;

                    endforeach;

                else:
                    // If we have a label but no items under that label, state there is nothing to show; so it doesn't
                    // look broken.
                    if(!empty($menu['label'])):
                        $menuDisplay .= "There are no {$section}s to display.";
                    endif;
                endif;

            $menuDisplay .= "</div>";
        $menuDisplay .= "</div>";

        return $menuDisplay;
    }
}