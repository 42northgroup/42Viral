<?php
/**
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package Plugin\ResumeWizard
 */

App::uses('ResumeAppModel', 'ResumeWizard.Model');

/**
 * @author Jason D Snider <jason.snider@42northgroup.com>
 * @package Plugin\ResumeWizard
 */
class Resume extends ResumeAppModel
{
    /**
     * The static name of the class
     * @access public
     * @var string
     */
    public $name = 'Resume';

    /**
     * Define the models table
     * @access public
     * @var string
     */
    public $useTable = 'resumes';

    /**
     * Defines has many relationships
     * @access public
     * @var array
     */
    public $hasMany = array(
        'ResumeEmailAddress'=>array(
            'className' => 'ResumeEmailAddress',
            'foreignKey' => 'resume_id',
            'dependent' => true
        )
    );

    /**
     * Defines belongs to relationships
     * @access public
     * @var array
     */
    public $belongsTo = array(
        'Person'=>array(
            'className' => 'Person',
            'foreignKey' => 'model_id',
            'dependent' => true
        )
    );

    /**
     * Defines has one relationsships
     * @access public
     * @var array
     */
    public $hasOne = array();

    /**
     * Defines validation
     * @var array
     * @access public
     */
    public $validate = array();

}