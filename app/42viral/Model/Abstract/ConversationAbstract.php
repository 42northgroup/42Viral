<?php

App::uses('AppModel', 'Model');

/**
 * Mangages the person object
 * @package App
 * @subpackage App.core
 */
abstract class ConversationAbstract extends AppModel
{
    
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'Conversation';
    
    /**
     *
     * @var string
     * @access public
     */
    public $useTable = 'conversations';
    
    /**
     *
     * @var array
     */
    public $actsAs = array(
        
        'Scrub'=>array(
            'Filters'=>array(
                'trim'=>'*',
                'html'=>array('body')
            )
        ),
        'Log'
    );
    
    
    /**
     * 
     * @var array
     * @access public
     */
    public $hasMany = array(
        'Conversation' => array(
            'className' => 'Conversation',
            'foreignKey' => 'content_id',
            'dependent' => true
        )
    );    
}