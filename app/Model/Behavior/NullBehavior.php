<?php
/**
 * Forces NULL when an empty value is passed from a field with a default value of NULL
 *
 * Copyright (c) 2011,  MicroTrain Technologies  (http://www.microtrain.net)
 * licensed under MIT (http://www.opensource.org/licenses/mit-license.php)
 *
 * @copyright  Copyright 2011, MicroTrain Technologies  (http://www.microtrain.net)
 * @package    app.core
 * @author     Jason D Snider <jsnider@jsnider77@gmil.com>
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class NullBehavior extends ModelBehavior
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

        $this->settings[$model->name] = $settings;

    }

    /**
     * @param object $model
     * @author Jason D Snider <jsnider@microtrain.net> 
     * @access public
     */
    public function beforeSave(&$model)
    {  
       //Loop all incomming data fields 
       foreach($model->data[$model->name] as $key => $value){
           
           //Is the field empty?
            if($value == ''){
                //Yes, check the schema
                $schema = $model->schema($key);

                //Is the schema default NULL ?
                if(is_null($schema['default'])){
                    //Yes, set the value to NULL instead of ''
                    $model->data[$model->name][$key] = NULL;
                }
            }
        }
       
        return true;
    }
    
}