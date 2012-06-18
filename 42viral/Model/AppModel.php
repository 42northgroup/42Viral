<?php
/**
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package 42viral
 */

App::uses('Model', 'Model');
/**
 * The parent calss for all 42Viral model logic
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral
 */
class AppModel extends Model
{

    /**
     * Application-wide behaviors
     * @access public
     * @var array
     */
    public $actsAs = array(
        'Containable',
        'Log'
    );

    /**
     * Works with ReturnInsertedIds Behaivior to return an array of the ids of inserted rows after a saveAll
     *
     * @access public
     * @var array
     */
    public $insertedIds = array();

    /**
     * Returns the User array of the current user
     * @access public
     * @return string
     */
    public function currentUser()
    {

        if(isset($_SESSION['Auth']['User'])) {
            return $_SESSION['Auth']['User'];
        } else {
            return false;
        }
    }

    /**
     * Returns a picklist ready array. This list can be flat, categorized or a partial list based on tags.
     * @access public
     * @param array $list The list to be parsed
     * @param array $tags
     * @param string $catgory
     * @param boolean $categories
     * @return array
     */
    protected function _listParser($list, $tags = null, $category = null, $categories = false){
        $options = array();

        //Return a flat list of elements matching specific tags
        if(is_array($tags)){
            foreach($tags as $tag){
                foreach($list as $option){
                    if(in_array($tag, $option['tags'])){
                        if(empty($option['_inactive'])){
                            $options[$option['_ref']] = $option['label'];
                        }
                    }
                }
            }
            goto end;
        }

        //Return a flat list based on a specific category
        if(!empty($category)){
            foreach($list as $key => $values){
                if($values['category'] == $category){
                    $options[$values['_ref']] = $values['label'];
                }
            }
            goto end;
        }

        //Returns a nested categorized list
        if(!empty($categories)){
            foreach($list as $option){
                if(empty($option['_inactive'])){
                    $options[$option['category']][$option['_ref']] = $option['label'];
                }
            }
            goto end;
        }

        //Returns a flat list of all options
        foreach($list as $key => $values){
            if(empty($values['_inactive'])){
                $options[$key] = $values['label'];
            }
        }

        end:

        return $options;
    }
}