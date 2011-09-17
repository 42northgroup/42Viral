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
App::uses('Handy', 'Lib');
/**
 * Generates a unique random string against a specified field
 *** @author Jason D Snider <jason.snider@42viral.org>
 */
class RandomBehavior extends ModelBehavior
{

    /**
     * @param object $model
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
     * @access public
     */
    public function beforeSave(&$model)
    {  
        
        foreach($this->settings[$model->name]['Fields'] as $field){ 
            $this->__unique($model, $field);
        }
        pr($model);
        return true;
    }
    
    /**
     * Recursively genrates random strings and checks the generated string for uniqueness.
     * Once the string is deemed unique, that value is returned.
     * @param string $field
     * @return string
     */
    private function __unique(&$model, $field){
        
        $string = $this->__generate($model, $field);
        
        if($this->__isDuplicate($model, $string, $field)){
            $this->__unique($field, null);
        }else{
            return $string;
        }
        
    }
    
    /**
     * @return boolean
     * @access private
     */
    private function __isDuplicate(&$model, $value, $field){
pr($model);
        $duplicateString = $model->find('first', array('conditions'=>array("{$model->name}.{$field}"=>$value)));
        
        if(empty($duplicateString)){
            return false;
        }else{
            return true;
        }
    }
    
    /**
     *
     * @param type $field 
     * @return string
     * @access private
     */
    private function __generate(&$model, $field){
        $randomString = null;
        
        if($field == 'case_number'){
            $randomString = Handy::random();
            $model->data[$model->name]['case_number'] = $randomString;
        }

        if($field == 'short_cut'){
            $randomString = Handy::random(4, true);
            $model->data[$model->name]['short_cur'] = $randomString;
        }
        
        return $randomString;
    }
}