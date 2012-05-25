<?php
/**
 * This model behavior will log the user who created or modified a record
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

/**
 * This model behavior will log the user who created or modified a record
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @package 42viral
 */
class LogBehavior extends ModelBehavior
{

    /**
     * Initializes the behavior
     * @access public
     * @param object $model 
     *
     */
    function setup(&$model){}

    /**
     * Appends "log" data to the array to be saved
     * @access public
     * @param object $model
     * @return boolean 
     */
    public function beforeSave(&$model)
    {
        $this->__appendLogFields($model);
        return true;
    }

    /**
     * Retrives the id of the user about to commit a save/update
     * @access private
     * @return string
     */
    private function __getUser()
    {
        if (isset($_SESSION['Auth']['User']['id'])) {
            return $_SESSION['Auth']['User']['id'];
        } else {
            return '4e24236d-6bd8-48bf-ac52-7cce4bb83359';
        }
    }

    /**
     * Provides the logic for appending the "log" data to the array to be saved
     * @access private
     * @param object $model
     *
     */
    private function __appendLogFields(&$model)
    {
        if (!isset($model->data[$model->name]['id'])) {
            $model->data[$model->name]['created_person_id'] = $this->__getUser();
        }

        $model->data[$model->name]['modified_person_id'] = $this->__getUser();
    }

}
