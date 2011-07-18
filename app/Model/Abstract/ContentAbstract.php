<?php

App::uses('AppModel', 'Model');

/**
 * Mangages the person object
 * @package App
 * @subpackage App.core
 */
abstract class ContentAbstract extends AppModel
{
    var $useTable = 'contents';
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
                'published'=>'Published'
            )
            
        ),
        
        'Scrub'=>array(
            'Filters'=>array(
                'trim'=>'*',
                'html'=>array('body', 'tease'),
                'plainTextNoHTML'=>array('id', 'title', 'description', 'keywords', 'canonical', 'syntax'),
            )
        ),
        
        'Seo'
    );
        
    /**
     * @access public
     */
    public function __construct() 
    {
        parent::__construct();
        
        $this->virtualFields = array(
            'url'=>"CONCAT('/',`{$this->alias}`.`object_type`,'/',`{$this->alias}`.`slug`)",
            'edit_url'=>"CONCAT('/profiles/',`{$this->alias}`.`object_type`,'_edit/',`{$this->alias}`.`id`)",
            'delete_url'=>"CONCAT('/profiles/',`{$this->alias}`.`object_type`,'_delete/',`{$this->alias}`.`id`)",
        );        
    }
        
    
}
?>
