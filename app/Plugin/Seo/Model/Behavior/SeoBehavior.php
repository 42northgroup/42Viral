<?php
/**
 * Copyright 2012, Jason D Snider (https://jasonsnider.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, Jason D Snider (https://jasonsnider.com)
 * @link https://jasonsnider.com
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Auto-magically populate deals with slug creation and basic SEO behaviors
 * @author Jason D Snider <jason.snider@42viral.org>
 */
class SeoBehavior extends ModelBehavior
{

    /**
     * A callback for preping an object
     * @param object $model
     * @return void
     * @access public
     */
    public function setup(&$model, $settings = array())
    {
        if(!is_array($settings)) {
            $settings = array();
        }
        
        if(isset($settings['convert'])){
           $this->settings[$model->name]['convert'] = $settings['convert'];
        }else{
           $this->settings[$model->name]['convert'] = 'title';
        }
        
    }

    /**
     * A callback for presave data manipulation
     * @param object $model
     * @return boolean
     * @access public
     */
    public function beforeSave(&$model)
    {        

        
        //We only auto-gen on creation
        if(!isset($model->data[$model->name]['id'])) {
            $baseSlug = $this->__baseSlug($model, $model->data[$model->name][$this->settings[$model->name]['convert']]);
            $model->data[$model->name]['base_slug'] = $baseSlug;
            $model->data[$model->name]['slug'] = $this->__slug($model, $baseSlug);
            
            $model->data[$model->name]['canonical'] = $this->__canonical($model, $model->data[$model->name]['slug']);
        }
        
        return true;
    }
        
    /**
     * Returns an SEO/URL freindly version of a given string
     * @param object $model
     * @param string $title the title of a content record as entered by the user
     * @return string the reformatted version of the input string
     * @access private 
     */
    private function __baseSlug(&$model, $title)
    {
        $baseSlug = '';
        $baseSlug = str_replace(' ', '-', trim($title));
        $baseSlug = strtolower($baseSlug);
        $baseSlug = ereg_replace("[^A-Za-z0-9_-]", "-", $baseSlug); //Whitelist URL Safe Chars
        $baseSlug = str_replace('---', '-', $baseSlug);
        $baseSlug = str_replace('--', '-', $baseSlug);

        return $baseSlug;
    }
    
    /**
     * Disambiguates slugs by appending a counter to the slug string.
     * @param object $model
     * @param string $baseSlug
     * @return array 
     * @access private 
     */
    private function __ambiguity(&$model,$baseSlug)
    {
        return $model->find('count', array('conditions'=>array('base_slug' => $baseSlug)));
    }
    
    /**
     * Returns an SEO/URL freindly version of a given string
     * @param object $model
     * @param string $title the title of a content record as entered by the user
     * @return string the reformatted version of the input string
     * @access private 
     */
    private function __slug(&$model, $baseSlug)
    {
        $slug = $baseSlug;
        
        $ambiguity = $this->__ambiguity(&$model, $baseSlug);

        if($ambiguity > 0){
            $slug .= '-' . $ambiguity;
        }
        
        return $slug;
    }
    
    /**
     * Sets a default canonical reference for newly created content
     * @param object $model
     * 
     * @param string $slug
     * @return string 
     * @access private 
     */
    private function __canonical(&$model, $slug){ 
        return Configure::read('Domain.url') . strtolower(Inflector::underscore($model->alias)) . "/{$slug}/"; 
    }

}