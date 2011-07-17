<?php

App::uses('Scrub', 'Lib');
App::uses('Sanitize', 'Utility');
/**
 * Provides data filtering at the model level
 * trim
 * nl2br
 * html
 * plainText
 * plainTextStripAll
 *
 * Copyright (c) 2011,  MicroTrain Technologies  (http://www.microtrain.net)
 * licensed under MIT (http://www.opensource.org/licenses/mit-license.php)
 *
 * @copyright  Copyright 2011, MicroTrain Technologies  (http://www.microtrain.net)
 * @package    app.core
 * @author     Jason D Snider <jsnider@jsnider77@gmil.com>
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class ScrubBehavior extends ModelBehavior
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
        
        //Determine which filters are requested and against what fields
        //Then build a filter map
        foreach($this->settings[$model->name]['Filters'] as $key => $value){ 
            $currentFilter = $key;
            if($value=='*'){
                $filterMap = array_keys($model->data[$model->name]);
            }else{
                $filterMap = $value;
            }
        }
        
        //Parse the filter map and apply the filters accordingly
        for($i=0; $i<count($filterMap); $i++){ 
            if(isset($model->data[$model->name][$filterMap[$i]] )){
                $model->data[$model->name][$filterMap[$i]] 
                        = $this->{$currentFilter}($model->data[$model->name][$filterMap[$i]]);
            }
        }
       
        return true;
    }
    
    /**
     * A wrapper method for trim()
     * @param string $value
     * @return string 
     * @author Jason D Snider <jsnider77@gmail.com>
     */
    public function trim($value){
        return trim($value);
    }
 
    /**
     * A wrapper for Scrub.html
     * @param string $value
     * @return string 
     * @author Jason D Snider <jsnider77@gmail.com>
     */     
    public function html($value){
        return Scrub::html($value);
    }
    
    /**
     * A wrapper for Scrub.plainText
     * @param string $value
     * @return string 
     * @author Jason D Snider <jsnider77@gmail.com>
     */   
    public function plainText($value){
        return Scrub::plainText($value);
    }    
    
    /**
     * A wrapper for Scrub.plainTextScrubAll
     * @param string $value
     * @return string 
     * @author Jason D Snider <jsnider77@gmail.com>
     */    
    public function plainTextNoHTML($value){
        return Scrub::plainTextNoHTML($value);
    }  
    
    /**
     * A wrapper for Scrub.nl2br
     * @param string $value
     * @return string 
     * @author Jason D Snider <jsnider77@gmail.com>
     */   
    public function nl2br($value){
        return Scrub::nl2br($value);
    }    
    
}