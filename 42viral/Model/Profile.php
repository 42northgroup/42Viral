<?php
/**
 * Mangages a users profile data
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Visssral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package       42viral\Person\User\Profile
 */

App::uses('AppModel', 'Model');
/**
 * Mangages a users profile data
 *
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 * @package       42viral\Person\User\Profile
 */
class Profile extends AppModel
{
    /**
     * Model name
     *
     * @var string
     * @access public
     */
    public $name = 'Profile';

    /**
     * Table the model uses
     * @var string
     * @access public
     */
    public $useTable = 'profiles';

    /**
     * belongsTo
     * @var array
     * @access public
     */
    public $belongsTo = array(
        'Person' => array(
            'className' => 'Person',
            'foreignKey' => 'owner_person_id',
            'dependent' => true
        )
    );

    /**
     * Defines the person model's has many relationships
     * @access
     * @var array
     */
    public $hasMany = array(
        'SocialNetwork' => array(
            'className' => 'SocialNetwork',
            'foreignKey' => 'model_id',
            'conditions'=>array('SocialNetwork.model'=>'Person'),
            'dependent' => true
        )
    );

    /**
     * Behaviors
     * @var array
     * @access public
     */
    public $actsAs = array(
        'Scrubable' => array(
            'Filters' => array(
                'trim' => '*',
                'htmlStrict' => array('bio', 'body')
            )
        )
    );
}