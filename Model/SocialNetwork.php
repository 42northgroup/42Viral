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
App::uses('User', 'Model');
App::uses('Sec', 'Utility');

/**
 * Mangages the social media objects
 * @author Jason D Snider <jason.snider@42northgroup.com>
 * @package 42viral\Person
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
     *
     * @var array
     * @access public
     */
    public $belongsTo = array(
        'Person' => array(
            'className' => 'Person',
            'foreignKey' => 'model_id',
            'conditions' => array(
                'SocialNetwork.model LIKE "Person"'
            ),
            'dependent' => true
        )
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
        'profile_url' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' =>'Please enter your profile url.',
                'last' => true
            ),
            'uniqueComposite' => array(
                'rule'    => array('uniquePersonToSocialNetworkIdentifier'),
                'message' => 'This network and profile url has already been added to your account.'
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

    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);

        $this->User = new User();
    }

    /**
     *
     * @return boolean
     * @access public
     */
    public function uniquePersonToSocialNetworkIdentifier()
    {
        $valid = false;

        $model = $this->data[$this->alias]['model'];
        $modelId = $this->data[$this->alias]['model_id'];
        $profile_url = $this->data[$this->alias]['profile_url'];
        $network = $this->data[$this->alias]['network'];

        $match = $this->find('first',
            array(
                'conditions'=>array(
                    'SocialNetwork.model' => $model,
                    'SocialNetwork.model_id' => $modelId,
                    "SocialNetwork.profile_url LIKE '$profile_url'",
                    'SocialNetwork.network' => $network
                ),
                'contain'=>array(),
                'fields'=>array('SocialNetwork.id')
            )
        );

        $valid = empty($match)?true:false;

        return $valid;
    }

    /**
     * Defines the list of supported social networks
     * @access private
     * @var array
     */
    private $__socialNetworks = array(
        'facebook'=> array(
            'label' => 'Facebook',
            'feed'=>'',
            'profile'=>'https://facebook.com/',
            'icon'=>'/img/graphics/social_media/production/facebook32.png'
        ),
        'github'=>array(
            'label' => 'GitHub',
            'feed'=>'',
            'profile'=>'https://github.com/',
            'icon'=>'/img/vendors/github-media/octocats/octocat32.png'
        ),
        'google_plus'=>array(
            'label' => 'Google+',
            'feed'=>'',
            'profile'=>'https://plus.google.com/',
            'icon'=>'/img/graphics/social_media/production/googleplus32.png'
        ),
        'linked_in'=>array(
            'label' => 'LinkedIn',
            'feed'=>'',
            'profile'=>'https://www.linkedin.com/in/',
            'icon'=>'/img/graphics/social_media/production/linkedin32.png'
        ),
        'twitter'=>array(
            'label' => 'Twitter',
            'feed'=>'',
            'profile'=>'https://twitter.com/#!/',
            'icon'=>'/img/graphics/social_media/production/twitter32.png'
        ),
        /*
        'yahoo'=>array(
            'label'=>'Yahoo!'
        ),
        'yelp'=>array(
            'label'=>'Yelp'
        )
        */
    );

    /**
     * Returns the fully defined social network array
     * @access public
     * @return array
     */
    public function getSocialNetworks(){
        return $this->__socialNetworks;
    }

    /**
     * Returns a simple list of social netorks. This list contains the social networks key and it's label
     * @access public
     * @return array
     */
    public function listSocialNetworks(){
        $socialNetworks = array();
        foreach($this->__socialNetworks as $key=>$value){
            $socialNetworks[$key] = $value['label'];
        }
        return $socialNetworks;
    }
}