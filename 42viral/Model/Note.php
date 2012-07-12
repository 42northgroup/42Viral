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
 *
 * @copyright   Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link        http://42viral.org 42Viral(tm)
 * @license     MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package 	42viral\Notes
 */

App::uses('AppModel', 'Model');
App::uses('Utility', 'Lib');
/**
 * The parent class for notes
 * @author James Rohacik <james.rohacik@42northgroup.com>
 * @package 42viral\Notes
 */
class Note extends AppModel
{

    /**
     * The static name of the model
     * @access public
     * @var string
     */
    public $name = 'Note';

    /**
     * Specifies the table to be used by the Note model and its children
     * @access public
     * @var string
     */
    public $useTable = 'notes';

    /**
     * Defines the default set of behaivors for all notes.
     * @access public
     * @var array
     */
    public $actsAs = array(
        'AuditLog.Auditable',

        'Scrubable'=>array(
            'Filters'=>array(
                'trim'=>'*',
                'htmlMedia'=>array('body'),
                'noHTML'=>array('id', 'note', 'syntax')
            )
        )
    );

    /**
     * belongsTo ralationship
     *
     * @var array
     * @access public
     */
    public $hasOne = array(
       // 'JobLead' => array(
       //     'className' => 'JobLead',
       //     'foreignKey' => 'model_id',
       //     'dependent' => true
       // )
    );

    /**
     * Specifies validation rules
     * @access public
     * @var array
     */
    public $validate = array(
        'note' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' =>"Please enter a note",
                'last' => true
            ),
        )
    );

    /**
     * Defines syntax types
     *
     * @access private
     * @var array
     */
    private $__listSyntaxTypes = array(
        'markdown'=>array(
            'label'=>'Markdown',
            '_ref'=>'markdown',
            '_inactive'=>false,
            'category'=>'',
            'tags'=>array()
        )
    );

    /**
     * Returns a key to value syntax types.
     * @access public
     * @param array $list
     * @param array $tags
     * @param string $catgory
     * @param boolean $categories
     * @return array
     */
    public function listSyntaxTypes($tags = null, $category = null, $categories = false){
        return $this->_listParser($this->__listSyntaxTypes, $tags, $category, $categories);
    }

    /**
     * Parses text as markdown
     * @access public
     * @param string $text
     * @return string
     */
    public function markdown($text){
        return  Utility::markdown($text);
    }

}