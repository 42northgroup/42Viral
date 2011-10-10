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
 */

/**
 * Keeps a history of a target table
 *
 * @package History
 * @author Jason D Snider <jason.snider@42viral.org>
 */
class HistoryBehavior extends ModelBehavior
{

    /**
     * @param object $model
     * @author Jason D Snider <jsnider@microtrain.net> 
     * @access public
     */
    public function setup(&$model, $settings = array())
    {
        if(!is_array($settings)) {
            $settings = array();
        }
        
        $this->settings = $settings;
    }

    /**
     * @param object $model
     * @author Jason D Snider <jsnider@microtrain.net> 
     * @access public
     */
    public function afterSave(&$model)
    {        

        $data = $model->findById($model->data[$model->name]['id']);
        $d = array();
        
        //Get the Hostory Model
        $historyModelName = $this->settings['historyModel'];
        $historyModel = ClassRegistry::init($historyModelName);
        

        //Set the history model data
        $d[$historyModelName] = $data[$model->name];
        
        //Set the history_id, this is the primary key of the tracked table
        $d[$historyModelName]['history_id'] = $data[$model->name]['id'];

        //Unset the history id so it can be properly generated
        unset($d[$historyModelName]['id']);

        //Save the history
        $historyModel->save($d['HistoryContent']);

        return true;
    }

}