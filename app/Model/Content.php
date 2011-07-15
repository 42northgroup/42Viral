<?php

App::uses('AppModel', 'Model');

/**
 * Mangages the person object
 * @package App
 * @subpackage App.core
 */
class Content extends AppModel
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
