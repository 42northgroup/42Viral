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
 * Mangages the conversation object.
 * A conversation is any reply, comment or attempt to start a conversation against any piece of Content data
 * 
 * @package app
 * @subpackage app.core
 * 
 ** @author Jason D Snider <jason.snider@42viral.org>
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