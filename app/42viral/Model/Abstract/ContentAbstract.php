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
App::uses('AppModel', 'Model');

/**
 * Mangages the person object
 * 
 * @package app
 * @subpackage app.core
 * 
 * @author Jason D Snider <jsnider77@gmail.com>
 */
abstract class ContentAbstract extends AppModel
{
    
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'Content';
    
    /**
     *
     * @var string
     * @access public
     */
    public $useTable = 'contents';
    
    /**
     *
     * @var array
     */
    public $actsAs = array(
        
        'Picklist' => array(
            
            'ObjectTypes'=>array(
                'page'=>'Page',
                'blog'=>'Blog',
                'post'=>'Post'
            ),
        
            'Syntax'=>array(
                'html'=>'HTML',
                'markdown'=>'Markdown'
            ),
        
            'Status'=>array(
                'draft'=>'Draft',
                'pending_review'=>'Pending Review',
                'published'=>'Published',
                'archived'=>'Archived' 
            )
            
        ),
        
        'Scrub'=>array(
            'Filters'=>array(
                'trim'=>'*',
                'htmlStrict'=>array('body', 'bio'),
                'noHTML'=>array('id', 'tease', 'title', 'description', 'keywords', 'canonical', 'syntax'),
            )
        ),
        
        'Seo'
    );
        
    /**
     * @access public
     */
    public function __construct($id = false, $table = null, $ds = null) 
    { 
        parent::__construct($id, $table, $ds);
        
        $this->virtualFields = array(
            'url'=>"CONCAT('/',`{$this->alias}`.`object_type`,'/',`{$this->alias}`.`slug`)",
            'edit_url'=>"CONCAT('/Contents/',`{$this->alias}`.`object_type`,'_edit/',`{$this->alias}`.`id`)",
            'delete_url'=>"CONCAT('/Contents/',`{$this->alias}`.`object_type`,'_delete/',`{$this->alias}`.`id`)",
        );        
    }
    
    /* === Content Validation Methods =============================================================================== */
    
    /**
     * Returns true if the blog is ready to be published
     * @return boolean 
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public
     */
    public function publishable(){
       
        $error = 0;
        
        if($this->data[$this->alias]['status'] != 'draft'){
            if (strlen($this->data[$this->alias]['title']) == 0){
                $error++;
            }

            if (strlen($this->data[$this->alias]['body']) < 10) {
                $error++;
            }        

            if (strlen($this->data[$this->alias]['tease']) < 10) {
                $error++;
            }  
        }
        
        if($error == 0){
            return true;
        }else{
            return false;
        }
        
        
    }
    
}