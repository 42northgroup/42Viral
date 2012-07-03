<?php
/**
 * PHP 5.3
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
 * @package       42viral\app
 */

App::uses('AppController', 'Controller');
App::uses('HttpSocketOauth', 'Lib');
App::uses('HttpSocket', 'Network/Http');
/**
 * Authenticates the user against various social media
 *
 * @package app
 * @subpackage app.core
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Lyubomir R Dimov <ldimov@microtrain.net>
 *
 * //Additional Credits
 * @author Neil Crookes <http://www.neilcrookes.com/>
 * @link http://www.neilcrookes.com/2010/04/12/cakephp-oauth-extension-to-httpsocket/
 * @see http://www.slideshare.net/episod/linkedin-oauth-zero-to-hero for oauth_token_secret
 */
 class OauthController extends AppController
{

    /**
     * Models this controller uses
     * @var array
     * @access public
     */
     public $uses = array(
        'Aro',
        'Tweet',
        'Linkedin',
        'Facebook',
        'SocialNetwork',
        'People',
        'User'
    );

    /**
     * Components
     * @var array
     * @access public
     */
    public $components = array(
        'Access'
    );

    /**
     * Helpers
     * @var array
     * @access public
     */
    public $helpers = array(
        'SocialMedia'
    );

    /**
     * Instanciates HttpSocketOauth and HttpSocket
     *
     * @param array $request
     * @param array $response
     */
    public function __construct($request = null, $response = null) {
        parent::__construct($request, $response);

        $this->HttpSocketOauth = new HttpSocketOauth();
        $this->HttpSocket = new HttpSocket();
    }

    /**
     * beforeFilter
     * @access public
     */
    public function beforeFilter(){

        parent::beforeFilter();

        $this->auth(array('*'));

        //Since this is the only action we want to deny we can get a little lazy
        $this->Auth->deny('connect');

        $this->Auth->autoRedirect = true;
        $this->Auth->loginRedirect = array('controller' => 'profiles', 'action' => 'view');
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
    }

    /**
     * Placeholder
     */
    public function connect(){

    }

    /**
     * The Twitter connect page. Authorizes "this" application against a users Twitter account
     * @param $get_token
     *
     * @access public
     */
    public function twitter_connect($get_token = null)
    {

        $request = array(
            'uri' => array(
                'scheme' => 'http',
                'host' => 'api.twitter.com',
                'path' => '/oauth/request_token'
            ),
            'method' => 'GET',
            'auth' => array(
                'method' => 'OAuth',
                'oauth_callback' => Configure::read('Twitter.callback') . '/' . $get_token,
                'oauth_consumer_key' => Configure::read('Twitter.consumer_key'),
                'oauth_consumer_secret' => Configure::read('Twitter.consumer_secret')
            )
        );

        try{
            $response = $this->HttpSocketOauth->request($request);
        }  catch (Exception $e){
            $this->Session->setFlash("A connection with Twitter could not be established at the moment.".
                                                                                " We apologize for the inconvenience.");
            $this->redirect($this->referer());
        }

        // Redirect user to twitter to authorize  my application
        parse_str($response, $response);

        //pr($response); die();
        $this->Session->write('Twitter.oauth_token_secret', $response['oauth_token_secret']);
        $this->redirect('http://api.twitter.com/oauth/authorize?oauth_token=' . $response['oauth_token']);

    }

    /**
     * The Twitter callback page. Takes the Twitter results and writes them to a session.
     * @param $get_token
     *
     * @access public
     */
    public function twitter_callback($get_token = null)
    {

        if(!isset ($this->params['url']['oauth_token']) && $this->params['url']['oauth_verifier']){
            $this->Session->setFlash("A connection with Twitter could not be established at the moment.".
                                                                                " We apologize for the inconvenience.");
            $this->redirect($this->referer());
        }

        // Issue request for access token
        $request = array(
            'uri' => array(
                'scheme' => 'http',
                'host' => 'api.twitter.com',
                'path' => '/oauth/access_token'
            ),
            'method' => 'GET',
            'auth' => array(
                'method' => 'OAuth',
                'oauth_consumer_key' => Configure::read('Twitter.consumer_key'),
                'oauth_consumer_secret' => Configure::read('Twitter.consumer_secret'),
                'oauth_token' => $this->params['url']['oauth_token'],
                'oauth_verifier' => $this->params['url']['oauth_verifier'],
                'oauth_token_secret' => $this->Session->read('Twitter.oauth_token_secret'),
            ),
        );

        $response = $this->HttpSocketOauth->request($request);
        parse_str($response, $response);
        
        $this->Session->write('Twitter.oauth_token_secret', $response['oauth_token_secret']);
        $this->Session->write('Twitter.oauth_token', $response['oauth_token']);

        $profile_url = "https://twitter.com/#!/{$response['screen_name']}";

        /*
        if($get_token != null){
            $this->redirect('/'.  urldecode($get_token));
        }
         *
         */

        if($this->Session->check('Auth.User.id')){

            if($this->SocialNetwork->doesOauthExist('twitter',
                                                    $response['user_id'],
                                                    $this->Session->read('Auth.User.id'))){

                $this->Aro->deleteAll(array('Aro.alias' => 'twitter_'.$response['user_id']));
                $this->Session->setFlash('You have been authenticated', 'success');
                $this->redirect($this->Auth->redirect());
            }else{
                $oauthUserId = $this->SocialNetwork->oauthed('twitter',
                                                              $response['user_id'],
                                                              null,
                                                              $this->Session->read('Auth.User.id'),
                                                              $profile_url);

                $this->__auth($oauthUserId, $response, 'Twitter');
            }

        }else{

            $oauthUserId = $this->SocialNetwork->oauthed('twitter', $response['user_id'], null, null, $profile_url);
            $this->__auth($oauthUserId, $response, 'Twitter');
        }

    }


    /**
     * The LinkedIn connect page. Authorizes "this" application against a users LinkedIn account
     * @param $get_token
     *
     * @access public
     */
    public function linkedin_connect($get_token = null)
    {

        $request = array(
            'uri' => array(
                'scheme' => 'https',
                'host' => 'api.linkedin.com',
                'path' => '/uas/oauth/requestToken',
            ),
            'method' => 'POST',
            'auth' => array(
                'method' => 'OAuth',
                'oauth_callback' => Configure::read('LinkedIn.callback') . '/' .$get_token,
                'oauth_consumer_key' => Configure::read('LinkedIn.consumer_key'),
                'oauth_consumer_secret' => Configure::read('LinkedIn.consumer_secret'),
            ),
            //Linked in was  complaining about the header not including the Content-Length
            'header' => array(
                'Content-Length' => 0
            ),
        );

        try{
            $response = $this->HttpSocketOauth->request($request);
        }  catch (Exception $e){
            $this->Session->setFlash("A connection with Linkedin could not be established at the moment.".
                                                                                " We apologize for the inconvenience.");
            $this->redirect($this->referer());
        }
        // Redirect user to LinkedIn to authorize  my application
        parse_str($response, $response);


        //since the oauth_token_secret is not pass back with the callback url we need to store it in the Session
        //so that we can use it when we are signing the oauth_access_token request
        $this->Session->write('LinkedIn.oauth_token_secret', $response['oauth_token_secret']);
        $this->Session->write('LinkedIn.oauth_expires', $response['oauth_expires_in']);
        $this->Session->write('LinkedIn.oauth_created', strtotime('now'));

        $this->redirect('https://www.linkedin.com/uas/oauth/authenticate?oauth_token=' . $response['oauth_token']);

    }


    /**
     * The LinkedIn callback page. Takes the LinkedIn results and writes them to a session.
     * @param $get_token
     *
     * @access public
     */
    public function linkedin_callback($get_token = null)
    {

        if(!isset ($this->params['url']['oauth_token']) && $this->params['url']['oauth_verifier']){
            $this->Session->setFlash("A connection with Linkedin could not be established at the moment.".
                                                                                " We apologize for the inconvenience.");
            $this->redirect($this->referer());
        }

        // Issue request for access token
        $request = array(
            'uri' => array(
                'scheme' => 'https',
                'host' => 'api.linkedin.com',
                'path' => '/uas/oauth/accessToken'
            ),
            'method' => 'POST',
            'auth' => array(
                'method' => 'OAuth',
                'oauth_consumer_key' => Configure::read('LinkedIn.consumer_key'),
                'oauth_consumer_secret' => Configure::read('LinkedIn.consumer_secret'),
                'oauth_token' => $this->params['url']['oauth_token'],
                'oauth_verifier' => $this->params['url']['oauth_verifier'],
                'oauth_token_secret' => $this->Session->read('LinkedIn.oauth_token_secret')
            ),
            'header' => array(
                'Content-Length' => 0
            ),
        );

        $response = $this->HttpSocketOauth->request($request);
        parse_str($response, $response);


        $this->Session->write('LinkedIn.oauth_token_secret', $response['oauth_token_secret']);
        $this->Session->write('LinkedIn.oauth_token', $response['oauth_token']);

        $request1 = array(
            'uri' => array(
                'scheme' => 'http',
                'host' => 'api.linkedin.com',
                'path' => '/v1/people/~:public'
            ),
            'method' => 'GET',
            'auth' => array(
                'method' => 'OAuth',
                'oauth_consumer_key' => Configure::read('LinkedIn.consumer_key'),
                'oauth_consumer_secret' => Configure::read('LinkedIn.consumer_secret'),
                'oauth_token' => $response['oauth_token'],
                'oauth_token_secret' => $response['oauth_token_secret']
            ),
            'header' => array(
                'Content-Length' => 0
            )
        );

        $response1 = $this->HttpSocketOauth->request($request1);
        $xml_response1 = simplexml_load_string($response1);
        parse_str($response1, $response1);

        $response1['user_id'] = $response1['amp;key'];

        $publicProfileUrl = 'public-profile-url';
        $response1['public_url'] = (String)$xml_response1->$publicProfileUrl;

        if($this->Session->check('Auth.User.id')){

            if($this->SocialNetwork->doesOauthExist('linked_in',
                                                     $response1['user_id'],
                                                     $this->Session->read('Auth.User.id'))){

                $this->Aro->deleteAll(array('Aro.alias' => 'linked_in_'.$response1['user_id']));
                $this->Session->setFlash('You have been authenticated', 'success');
                $this->redirect($this->Auth->redirect());
            }else{

                $oauthUserId = $this->SocialNetwork->oauthed('linked_in',
                                                                $response1['user_id'],
                                                                null,
                                                                $this->Session->read('Auth.User.id'),
                                                                $response1['public_url']);

                $this->__auth($oauthUserId, $response, 'LinkedIn');
            }

        }else{

            $oauthUserId = $this->SocialNetwork->oauthed('linked_in',
                                                        $response1['user_id'],
                                                        null,
                                                        null,
                                                        $response1['public_url']);

            $this->__auth($oauthUserId, $response, 'LinkedIn');
        }

    }

    /**
     * The Facebook connect page. Authorizes "this" application against a users Facebook account
     * @param $get_token
     *
     * @access public
     */
    public function facebook_connect($get_token = null)
    {
        $this->redirect("https://www.facebook.com/dialog/oauth?client_id=".Configure::read('Facebook.consumer_key')
                                                    ."&redirect_uri=".urlencode(Configure::read('Facebook.callback')
                                                                                                . '/' . $get_token)
                                                    ."&scope=read_stream,offline_access,publish_stream");

    }


    /**
     * The Facebook callback page. Takes the Facebook results and writes them to a session.
     * @param $get_token
     *
     * @access public
     */
    public function facebook_callback($get_token = null)
    {
        if(!isset ($this->params['url']['code'])){
            $this->Session->setFlash("A connection with Facebook could not be established at the moment.".
                                                                                " We apologize for the inconvenience.");
            $this->redirect($this->referer());
        }

        $request = array(
            'uri' => array(
                'scheme' => 'https',
                'host' => 'graph.facebook.com',
                'path' => '/oauth/access_token',
                'query' => array(
                    'client_id' => Configure::read('Facebook.consumer_key'),
                    'redirect_uri' => Configure::read('Facebook.callback'). '/' . $get_token,
                    'client_secret' => Configure::read('Facebook.consumer_secret'),
                    'code' => $this->params['url']['code']
                )
            ),
            'method' => 'GET'
        );

        $response = $this->HttpSocketOauth->request($request);
        $params = null;
        parse_str($response, $params);

        $request1 = array(
            'uri' => array(
                'scheme' => 'https',
                'host' => 'graph.facebook.com',
                'path' => '/me',
                'query' => array(
                    'access_token' => $params['access_token']
                )
            ),
            'method' => 'GET'
        );


        $this->Session->write('Facebook.oauth_token', $params['access_token']);

        $user = json_decode($this->HttpSocketOauth->request($request1));

        if($this->Session->check('Auth.User.id')){

            if($this->SocialNetwork->doesOauthExist('facebook', $user->id, $this->Session->read('Auth.User.id'))){

                $this->Aro->deleteAll(array('Aro.alias' => 'facebook_'.$user->id));
                $this->Session->setFlash('You have been authenticated', 'success');
                $this->redirect($this->Auth->redirect());
            }else{

                $oauthUserId = $this->SocialNetwork->oauthed('facebook',
                                                                $user->id,
                                                                $params['access_token'],
                                                                $this->Session->read('Auth.User.id'),
                                                                $user->link);

                $this->__auth($oauthUserId, $response, 'Facebook');
            }

        }else{

            $oauthUserId = $this->SocialNetwork->oauthed('facebook', $user->id, $params['access_token'], $user->link);
            $this->__auth($oauthUserId, $response, 'Facebook');
        }

    }

    /**
     * The Google connect page. Authorizes "this" application against a users Google account
     *
     * @access public
     */
    public function google_connect()
    {
        $this->redirect("https://accounts.google.com/o/oauth2/auth?".
                            "scope=".urlencode('https://www.googleapis.com/auth/plus.me')."&".
                            "state=%2Fprofile&".
                            "redirect_uri=".  urlencode(Configure::read('GooglePlus.callback'))."&".
               "response_type=code&client_id=".Configure::read('GooglePlus.consumer_key'));

    }

    /**
     * The Google callback page. Takes the Google results and writes them to a session.
     * @param $get_token
     *
     * @access public
     */
    public function google_callback($get_token = null)
    {
        if(!isset ($this->params['url']['code'])){
            $this->Session->setFlash("A connection with Google could not be established at the moment.".
                                                                                " We apologize for the inconvenience.");
            $this->redirect($this->referer());
        }

        $request = array(
            'uri' => array(
                'scheme' => 'https',
                'host' => 'accounts.google.com',
                'path' => '/o/oauth2/token'
            ),
            'method' => 'POST',
            'body' => array(
                'code' => $this->params['url']['code'],
                'client_id' => Configure::read('GooglePlus.consumer_key'),
                'client_secret' => Configure::read('GooglePlus.consumer_secret'),
                'redirect_uri' => Configure::read('GooglePlus.callback'),
                'grant_type' => 'authorization_code'
            ),
            'header' => array(
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Content-Length'
            )
        );

        $response = $this->HttpSocketOauth->request($request);

        $params = null;
        $params = json_decode($response);

        $this->Session->write('GooglePlus.oauth_token', $params->access_token);
        $this->Session->write('GooglePlus.oauth_expires', $params->expires_in);
        $this->Session->write('GooglePlus.oauth_created', strtotime('now'));

        $request1 = array(
            'uri' => array(
                'scheme' => 'https',
                'host' => 'www.googleapis.com',
                'path' => '/plus/v1/people/me'
            ),
            'method' => 'GET',
            'query' => array(
                'key' => Configure::read('GooglePlus.consumer_key'),
                'alt' => 'json',
            ),
            'header' => array(
                'Authorization' => 'OAuth '.$params->access_token
            )
        );

        $response1 = $this->HttpSocketOauth->request($request1);

        $user = json_decode($response1->body);

        if($this->Session->check('Auth.User.id')){

            if($this->SocialNetwork->doesOauthExist('google_plus', $user->id, $this->Session->read('Auth.User.id'))){

                $this->Aro->deleteAll(array('Aro.alias' => 'google_plus_'.$user->id));
                $this->Session->setFlash('You have been authenticated', 'success');
                $this->redirect($this->Auth->redirect());
            }else{

                $oauthUserId = $this->SocialNetwork->oauthed('google_plus',
                                                                $user->id,
                                                                $params->access_token,
                                                                $this->Session->read('Auth.User.id'),
                                                                $user->url);

                $this->__auth($oauthUserId, $response1, 'GooglePlus');
            }

        }else{

            $oauthUserId = $this->SocialNetwork->oauthed('google_plus', $user->id, $params->access_token, $user->url);
            $this->__auth($oauthUserId, $response1, 'GooglePlus');
        }

    }

    /**
     * A wrapper for common authentication and session functionality
     * @param string $userId ID of the user we are authenticating
     * @param array $response
     * @param string $oauthKey
     * @todo Generalize this with User::login()
     * @todo make use of or remove $error
     */
    private function __auth($userId, $response, $oauthKey)
    {
        //$user = $this->User->getUserWith($userId, 'session_data');
        $user = $this->User->find('first', array(
            'conditions' => array('or' => array(
                'User.id' => $userId,
                'User.username' => $userId,
                'User.email' => $userId
            )),
            'contain' => array(
                'Profile' => array(),
                'UserSetting' => array(),
            )
        ));

        if(empty($user)){

            $this->log("User not found {$user['User']['username']}", 'weekly_user_login');
            return false;
        }else{

            if($this->Auth->login($user['User'])){

                $this->Session->write('Auth.User', $user['User']);
                $this->Session->write('Auth.User.Profile', $user['Profile']);
                $this->Session->write('Auth.User.Settings', $user['UserSetting']);

                $session = $this->Session->read('Auth');
                $oauthData = array($oauthKey => $response);

                $this->Session->write('Auth', array_merge($session, $oauthData));

                $this->__createAro($user['User']['username'], $user['User']['id']);

                //$this->Access->permissions($user['User']);

                $this->Session->setFlash('You have been authenticated', 'success');
                $this->redirect($this->Auth->redirect());


            }else{
                return false;
            }

        }

    }

    /**
     * Creates an aro entry(needed for ACLs) for a user if there isn't one
     *
     * @param string $alias alias of the user(username column from people table) for which we are creating the aro entry
     * @param string $foreign_key ID of the user(from people table) for which we are creating the aro entry
     * @return boolean
     */
    private function __createAro($alias, $foreign_key)
    {
        $aro = $this->Aro->findByAlias($alias);

        if( empty ($aro) ){
            $this->Acl->Aro->create(array(
                'model'=>'User',
                'foreign_key'=>$foreign_key,
                'alias'=>$alias, 0, 0));

            return($this->Acl->Aro->save());
        }else{
            return true;
        }

    }

}