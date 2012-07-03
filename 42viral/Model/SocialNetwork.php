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
App::uses('Profile', 'Model');
App::uses('Sec', 'Utility');

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

    /**
     * Wraps the checking and creation logic
     * @param string $service
     * @param string $oauthId
     * @return string
     */
    public function oauthed($service, $oauthId, $token=null, $user_id=null, $page=null){

        $theOauthed = $this->getOauthed($service, $oauthId);
        if($theOauthed){

            return $theOauthed;

        }else{

            return $this->createOauthed($service, $oauthId, $token, $user_id, $page);
        }
    }

    /**
     * Gets an Oauth record
     * @param string $service
     * @param string $oauthId
     * @return string
     */
    public function getOauthed($service, $oauthId){
        $oauthed =
            $this->find('first',
                array(
                    'conditions'=>array(
                        'SocialNetwork.network'=>$service,
                        'SocialNetwork.oauth_id'=>$oauthId
                    )
                )
            );

        if(!empty($oauthed)){
            return $oauthed['SocialNetwork']['model_id'];
        }else{
            return false;
        }
    }

    /**
     * Creates a new OAuth entry and person
     * @param string $service
     * @param string $oauthId The id from the Oauth service, ex. Twitter.member_id
     * @return string
     */
    public function createOauthed($service, $oauthId, $token=null, $userId=null, $page=null){

        //Is this an exisiting user?
        if(is_null($userId)){

            //Build the Person reocrd
            $oauthedUser = array();
            $oauthedUser['User']['username'] = "{$service}_{$oauthId}";
            $oauthedUser['User']['password'] = Configure::read('Oauth.password');
            $oauthedUser['User']['verify_password'] = Configure::read('Oauth.password');

            if($this->User->createUser($oauthedUser['User'])){

                $userId = $this->User->id;

                $oauthed = array();
                $oauthed['SocialNetwork']['model'] = "Person";
                $oauthed['SocialNetwork']['model_id'] = $userId;
                $oauthed['SocialNetwork']['oauth_id'] = $oauthId;
                $oauthed['SocialNetwork']['network'] = $service;
                $oauthed['SocialNetwork']['profile_url'] = $page;
                $oauthed['SocialNetwork']['oauth_token'] = $token;

                if($this->save($oauthed)){
                    return $userId;
                }
            }else{
                //The save failed, get out
                return false;
            }

        }

        if(!is_null($userId)){
            //Build the Oauth record
            $oauthed = array();
            $oauthed['SocialNetwork']['model'] = "Person";
            $oauthed['SocialNetwork']['model_id'] = $userId;
            $oauthed['SocialNetwork']['oauth_id'] = $oauthId;
            $oauthed['SocialNetwork']['network'] = $service;
            $oauthed['SocialNetwork']['profile_url'] = $page;
            $oauthed['SocialNetwork']['oauth_token'] = $token;

            if($this->save($oauthed)){
                return $userId;
            }else{
                //Everything worked out, return the user id
                return $userId;
            }
        }
        //If we've come this far, something bad happened
        return false;
    }

    /**
     * Checks to see if the user has used this service to authenticate themselves
     * if the past and if they are cuurently logged in using that service.
     *
     * If they are logged using once service and authenticate using another, the
     * second once will be merged into the first one and it will return true.
     *
     * If this is the first time the user is authenticating with this service it will
     * return false
     *
     * @param stirng $service
     * @param stirng $service_id
     * @param string $user_id
     * @return bollean
     */

    public function doesOauthExist($service, $service_id, $user_id)
    {
        $oauth = $this->find('first', array(
            'conditions' => array(
                    'SocialNetwork.network' => $service,
                    'SocialNetwork.oauth_id' => $service_id
                )
        ));

        if(!empty ($oauth)){

            if($oauth['SocialNetwork']['model_id'] != $user_id){

                $oauth_person_id = $oauth['SocialNetwork']['model_id'];

                $profile = new Profile();
                $profile->deleteAll(array('Profile.owner_person_id' => $oauth_person_id));

                $db = ConnectionManager::getDataSource('default');
                $tables = $db->listSources();

                $fields = array();

                foreach($tables as $table) {
                    if(!in_array($table, array('aros', 'acos', 'aros_acos'))){

                        $result = $db->query('DESCRIBE '. $table);
                        $fields =  Set::extract($result, '/COLUMNS/Field');
                        $class_name = Inflector::classify($table);

                        /*

                        if(class_exists($class_name)){
                            $loaded_table = ClassRegistry::init($class_name);
                        }else{

                            $pluginDirs = App::objects('plugin', null, false);

                            foreach ($pluginDirs as $pluginDir){
                                if(file_exists('Plugin'. DS .$pluginDir. DS .'Model'. DS .$class_name.'php')){
                                    App::import('Model', $pluginDir.'.'.$class_name);

                                    if(class_exists($class_name)){
                                        $loaded_table = ClassRegistry::init($class_name);
                                    }else{
                                        echo 'class not found';
                                    }
                                }else{
                                    echo 'model not found';
                                }
                            }
                        }

                        if(!isset ($loaded_table)){
                            $loaded_table = ClassRegistry::init($class_name);
                        }

                         *
                         */

                        foreach($fields as $field){

                            if(!(strpos($field, 'person_id') === false)){

                                $query = "UPDATE {$table} SET $table.$field = '{$user_id}'
                                            WHERE $table.$field LIKE '$oauth_person_id'";

                                $this->query($query);

                                $query = "";

                                /*
                                $loaded_table->updateAll(
                                        array($class_name. '.' .$field => "'$user_id'"),
                                        array($class_name. '.' .$field." LIKE '$oauth_person_id'")
                                    );
                                 *
                                 */
                            }
                        }

                    }

                }

                App::uses('User', 'Model');
                $user = ClassRegistry::init('User');
                $user->delete($oauth_person_id);

            }
            return true;
        }else{

            return false;
        }
    }

}