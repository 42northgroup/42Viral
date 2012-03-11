<?php
App::uses('Group', 'Model');

/**
 * Provides a means by which to painlessly create sitemaps against any data
 * 
 * @package app
 * @subpackage app.core
 * 
 * @author Jason D Snider 
 */
class Sitemap extends AppModel
{
    /**
     * 
     * @var array
     * @access public
     */
    public $belongsTo = array(
        'Content' => array(
            'className' => 'Content',
            'foreignKey' => 'model_id',
            'conditions'=>array('Content.model_id'),
            'dependent' => true
        )
    );
}
