<?php
/**
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package 42Viral\Conversation
 */

App::uses('AppModel', 'Model');
/**
 * Allows a conversation to be created against any instance of any content object
 * A conversation is any reply, comment or attempt to start a conversation against any piece of Content data
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42Viral\Content\Conversation
 */
class Conversation extends AppModel
{
    
    /**
     * The static name of the conversation object
     * @access public
     * @var string
     */
    public $name = 'Conversation';
    
    /**
     * Specifies the table used by the conversation object
     * @access public
     * @var string
     */
    public $useTable = 'conversations';
    
    /**
     * Specifies the behaviors invoked by the conversation model
     * @access public 
     * @var array
     */
    public $actsAs = array(
        'ContentFilters.AntiSpamable'=>array(
            'map'=>array(
                'name'=>'comment_author_name',
                'email'=>'comment_author_email',
                'uri'=>'comment_author_url',
                'body'=>'comment_content',
                'front_page'=>'blog'
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
     * Defines the conversation models has many relationships
     * @access public
     * @var array
     */
    public $hasMany = array(
        'Conversation' => array(
            'className' => 'Conversation',
            'foreignKey' => 'content_id',
            'dependent' => true
        )
    );    
    
    /**
     * Defines the conversation belongs to relationships
     * @access public
     * @var array
     */
    public $belongsTo = array(
        'CreatedPerson' => array(
            'className' => 'Person',
            'foreignKey' => 'created_person_id',
            'dependent' => true
        )
    );  
    
    /**
     * Defines a conversations model validation
     * @access public
     * @var array
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
    
    /**
     * Adds the approve/deny flag to the data set prior to a save operation.
     * @access public 
     * @return boolean
     */
    public function beforeSave(){

        //Use the span status to auto approve/deny comments
        switch($this->data[$this->alias]['spam_status']){ 
            case -1:
               $this->data[$this->alias]['status'] = 'pending'; 
            break;
        
            case 0:
                $this->data[$this->alias]['status'] = 'approved';
            break;
        
            case 1:
                $this->data[$this->alias]['status'] = 'denied';
            break;
            
            default:
               $this->data[$this->alias]['status'] = 'pending'; 
            break;
        }
        return true;
    }
}