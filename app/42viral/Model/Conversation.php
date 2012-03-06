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
 * @author Jason D Snider <jason.snider@42viral.org>
 */
class Conversation extends AppModel
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
     * @access public 
     */
    public $actsAs = array(
        'BadBehavior.Akismet'=>array(
            'map'=>array(
                'name'=>'comment_author_name',
                'email'=>'comment_author_email',
                'url'=>'comment_author_url',
                'body'=>'comment_content'
            )
        ),
        'ContentFilters.Scrubable'=>array(
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
    
    public $belongsTo = array(
        'CreatedPerson' => array(
            'className' => 'Person',
            'foreignKey' => 'created_person_id',
            'dependent' => true
        )
    );  
    
    /**
     * 
     * @var array
     * @access public
     */
    public $validate = array(
        'body' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' =>'Please say something',
                'last' => true
            ),
        ),
        'name' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' =>'Please tell us your name',
                'last' => true
            ),
        ),
        'email' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' =>"Please enter an email address",
                'last' => true
            ),
            'email' => array(
                'rule' => 'email',
                'message' =>"Please enter a valid email.",
                'last' => true
            ),
        ),
    );    
}