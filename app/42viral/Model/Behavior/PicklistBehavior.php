<?php
/**
 * This model behavior is used to provide system controlled picklists on a given column
 *
 * var $actsAs = array('Listable'=>array('column'=>array('value1'=>'Label 1', 'value2'=>'Label 2')));
 *
 * Copyright (c) 2011,  MicroTrain Technologies  (http://www.microtrain.net)
 * licensed under MIT (http://www.opensource.org/licenses/mit-license.php)
 *
 * @copyright  Copyright 2011, MicroTrain Technologies  (http://www.microtrain.net)
 * @package    app
 * @subpackage app.core
 * @author     Jason D Snider <jsnider@microtrain.net>
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class PicklistBehavior extends ModelBehavior
{

    public $settings = array();

    public function setup(&$model, $settings = array())
    { 
        if(!is_array($settings)) {            
            $settings = array();
        }

        $this->settings[$model->name] = $settings;
    }

    /**
     * Returns the enum values as a picklist
     * @param string $columnName
     * @return array
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function picklist(&$model, $columnName){
        return $this->settings[$model->name][$columnName];
    }

}