<?php
/**
 * Generates a unique random string against a specified field
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

App::uses('Handy', 'Lib');

/**
 * Generates a unique random string against a specified field
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral
 */
class RandomBehavior extends ModelBehavior
{

    /**
     * Initializes the behavior
     * @access public
     * @param object $model A reference to the current model
     * @param array accepts configuration parameters for a particular instance of this behavior
     *
     */
    public function setup(&$model, $settings = array())
    {
        if(!is_array($settings)) {
            $settings = array();
        }

        $this->settings[$model->name] = $settings;

    }

    /**
     * Inject a pseudo-random value into the specified field(s) prior to save.
     * @access public
     * @param object $model A reference to the current model
     *
     */
    public function beforeSave(&$model)
    {  
        if(!isset($model->data[$model->name]['id'])){
            foreach($this->settings[$model->name]['Fields'] as $field){ 
                $this->__unique($model, $field);
            }
        }
        return true;
    }
    
    /**
     * Recursively genrates random strings and checks the generated string for uniqueness.
     * Once the string is deemed unique, that value is returned.
     * @access private
     * @param object $model A reference to the current model
     * @param string $field the field name or database column to be randomized
     * @param string $string a to be schecked for uniqness, this would rarely be used outside of testing
     * @return string
     */
    private function __unique(&$model, $field, $string = null){
        
        if(is_null($string)){
            $string = $this->__generate($model, $field);
        }

        if($this->__isDuplicate($model, $string, $field)){
            $this->__unique($model, $field, null);
        }else{
            return $string;
        }
        
    }
    
    /**
     * Return true if $string already exists in the given Model.column
     * @access private
     * @param object $model A reference to the current model
     * @param string $string The string to checked for duplicates
     * @param string $field The field to be randomized
     * @return boolean
     */
    private function __isDuplicate(&$model, $string, $field){

        $duplicateString = $model->find('first', array('conditions'=>array("{$model->name}.{$field}"=>$string)));
        
        if(empty($duplicateString)){
            return false;
        }else{
            return true;
        }
    }
    
    /**
     * Return a random string to be used for setting Model.coulmn to the returned random string.
     * @access private
     * @param object $model A reference to the current model
     * @param string $field The field to be randomized
     * @return string
     */
    private function __generate(&$model, $field){
        $randomString = null;
        
        //Adjust randomization parameters for various fields.
        switch($field){
            case 'short_cut':
                $randomString = Handy::random(4);
            break;
        
            default:
               $randomString = Handy::random(); 
            break;    
        }
        
        $model->data[$model->name][$field] = $randomString;
        
        return $randomString;
    }
}