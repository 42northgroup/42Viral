<?php
/**
 * Mangages the social media objects
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package 42viral\Address
 */

App::uses('AppModel', 'Model');
/**
 * Mangages the social media objects
 * @author Jason D Snider <jason.snider@42northgroup.com>
 * @package 42viral\Person\User\Profile
 */
class SocialNetwork extends AppModel
{
    /**
     * The static name of the address object
     * @access public
     * @var string
     */
    public $name = 'SocialNetwork';
    
    /**
     * Specifies the table to be used by the address model
     * @access public
     * @var string
     */
    public $useTable = 'social_networks';
    
    /**
     * Specifies the behaviors inoked by the address object
     * @access public
     * @var array
     */
    public $actsAs = array(
        'AuditLog.Auditable',
        'Log'
    );
    
    /**
     * Specifies the validation rules for the social media model
     * @access public
     * @var array
     */
    public $validate = array(
        'profile_id' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' =>'Please add a profile id.',
                'last' => true
            ),
        ),        
        'profile' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' =>'Please enter your profile identifier.',
                'last' => true
            ),
        ),
        'network' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' =>'Please choose a network.',
                'last' => true
            ),
        )
    );

}