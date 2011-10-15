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

App::uses('Scrub', 'Lib');
App::uses('Sanitize', 'Utility');

/**
 * A class for sanitizing user submitted data
 *** @author     Jason D Snider <jsnider@jsnider77@gmil.com>
 */
class ScrubBehavior extends ModelBehavior
{

    /**
     * @param object $model
     *** @author Jason D Snider <jsnider@microtrain.net> 
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
     *** @author Jason D Snider <jsnider@microtrain.net> 
     * @access public
     */
    public function beforeSave(&$model)
    {  
        
        //Determine which filters are requested and against what fields
        //Then build a filter map
        foreach($this->settings[$model->name]['Filters'] as $key => $value){ 
            $currentFilter = $key;
            if($value=='*'){
                $filterMap[$currentFilter] = array_keys($model->data[$model->name]);
            }else{
                $filterMap[$currentFilter] = $value;
            }
        }
        
        
        foreach($filterMap as $key => $value){
            
            //Parse the filter map and apply the filters accordingly
            for($i=0; $i<count($value); $i++){ 
                
                //echo 'Applying ' . $key . ' to ' . $value[$i] .'<br>';
                
                if(isset($model->data[$model->name][$value[$i]] )){
                    //The data
                    $model->data[$model->name][$value[$i]] 
                            //The filter
                            = $this->{$key}($model->data[$model->name][$value[$i]]);
                }
            }
        }
       
        return true;
    }
    
    /**
     * A wrapper method for trim()
     * @param string $value
     * @return string 
     *** @author Jason D Snider <jason.snider@42viral.org>
     */
    public function trim($value){
        return trim($value);
    }
 
    /**
     * A wrapper for Scrub.html
     * @param string $value
     * @return string 
     *** @author Jason D Snider <jason.snider@42viral.org>
     */     
    public function html($value){
        return Scrub::html($value);
    }
    
    /**
     * A wrapper for Scrub.htmlStrict
     * @param string $value
     * @return string 
     *** @author Jason D Snider <jason.snider@42viral.org>
     */     
    public function htmlStrict($value){
        return Scrub::htmlStrict($value);
    }
    
    /**
     * A wrapper for Scrub.safe
     * @param string $value
     * @return string 
     *** @author Jason D Snider <jason.snider@42viral.org>
     */   
    public function safe($value){
        return Scrub::safe($value);
    }    
    
    /**
     * A wrapper for Scrub.noHTML
     * @param string $value
     * @return string 
     *** @author Jason D Snider <jason.snider@42viral.org>
     */    
    public function noHTML($value){
        return Scrub::noHTML($value);
    }  
    
}