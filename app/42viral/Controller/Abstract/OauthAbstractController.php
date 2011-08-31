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

App::uses('AppController', 'Controller');
App::uses('HttpSocketOauth', 'Lib');
App::uses('HttpSocket', 'Network/Http');
/**
 * @package app
 * @subpackage app.core
 * @author Jason D Snider <jsnider77@gmail.com>
 * @author Lyubomir R Dimov <ldimov@microtrain.net>
 * 
 * //Additional Credits
 * @author Neil Crookes <http://www.neilcrookes.com/>
 * @link http://www.neilcrookes.com/2010/04/12/cakephp-oauth-extension-to-httpsocket/
 * @see http://www.slideshare.net/episod/linkedin-oauth-zero-to-hero for oauth_token_secret
 */
abstract class OauthAbstractController extends AppController
{

    /**
     * @var array
     * @access public
     */
    public $uses = array('Oauth', 'People', 'User', 'Aro');

    /**
     * @var array
     * @access public
     */
    public $components = array('Access');

    public function __construct($request = null, $response = null) {
        parent::__construct($request, $response);

        $this->HttpSocketOauth = new HttpSocketOauth();
        $this->HttpSocket = new HttpSocket();
    }

    /**
     * @access public
     */
    public function beforeFilter(){

        parent::beforeFilter();

        $this->auth(array('*'));

        //Since this is the only action we want to deny we can get a little lazy
        $this->Auth->deny('connect');

        $this->Auth->autoRedirect = true;
        $this->Auth->loginRedirect = array('controller' => 'members', 'action' => 'view');
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
    }

    /**
     * Placeholder
     */
    public function connect(){

    }
    
    /**
     * The Twitter connect page. Authorizes "this" application against a users Twitter account
     * @return void
     * @access public
     */
    public function twitter_connect()
    {
        $this->serviceConfiguration('Twitter', 3);

        $request = array(
            'uri' => array(
                'host' => 'api.twitter.com',
                'path' => '/oauth/request_token'
            ),
            'method' => 'GET',
            'auth' => array(
                'method' => 'OAuth',
                'oauth_callback' => Configure::read('Twitter.callback'),
                'oauth_consumer_key' => Configure::read('Twitter.consumer_key'),
                'oauth_consumer_secret' => Configure::read('Twitter.consumer_secret')
            )
        );

        $response = $this->HttpSocketOauth->request($request);

        // Redirect user to twitter to authorize  my application
        parse_str($response, $response);
        $this->redirect('http://api.twitter.com/oauth/authorize?oauth_token=' . $response['oauth_token']);

    }

    /**
     * The Twitter callback page. Takes the Twitter results and writes them to a session.
     * @return void
     * @access public
     */
    public function twitter_callback()
    {
        
        $this->serviceConfiguration('Twitter', 3);
        
        // Issue request for access token
        $request = array(
            'uri' => array(
                'host' => 'api.twitter.com',
                'path' => '/oauth/access_token'
            ),
            'method' => 'POST',
            'auth' => array(
                'method' => 'OAuth',
                'oauth_consumer_key' => Configure::read('Twitter.consumer_key'),
                'oauth_consumer_secret' => Configure::read('Twitter.consumer_secret'),
                'oauth_token' => $this->params['url']['oauth_token'],
                'oauth_verifier' => $this->params['url']['oauth_verifier']
            ),
        );

        $response = $this->HttpSocketOauth->request($request);
        parse_str($response, $response);

        /*
        $response = array(
            'oauth_token' => "thisisafakeoauthtokenstring",
            'oauth_token_secret' => "thisisafakeoauthtokensecretstring",
            'user_id' => "12345678",
            'screen_name' => "Fake_User"
        );
        */

        if($this->Session->check('Auth.User.id')){

            if($this->Oauth->doesOauthExist('twitter', $response['user_id'], $this->Session->read('Auth.User.id'))){

                $this->Aro->deleteAll(array('Aro.alias' => 'twitter_'.$response['user_id']));
                $this->Session->setFlash('You have been authenticated', 'success');
                $this->redirect($this->Auth->redirect());
            }else{
                $oauthUserId = $this->Oauth->oauthed('twitter',
                                                    $response['user_id'],
                                                    null,
                                                    $this->Session->read('Auth.User.id')
                                                );
                $this->__auth($oauthUserId, $response, 'Twitter');
            }

        }else{

            $oauthUserId = $this->Oauth->oauthed('twitter', $response['user_id']);
            $this->__auth($oauthUserId, $response, 'Twitter');
        }
    }

    /**
     * The LinkedIn connect page. Authorizes "this" application against a users LinkedIn account
     * @return void
     * @access public
     */
    public function linkedin_connect()
    {
        
        $this->serviceConfiguration('LinkedIn', 3);
        
        $request = array(
            'uri' => array(
                'scheme' => 'https',
                'host' => 'api.linkedin.com',
                'path' => '/uas/oauth/requestToken',
            ),
            'method' => 'POST',
            'auth' => array(
            'method' => 'OAuth',
            'oauth_callback' => Configure::read('LinkedIn.callback'),
            'oauth_consumer_key' => Configure::read('LinkedIn.consumer_key'),
            'oauth_consumer_secret' => Configure::read('LinkedIn.consumer_secret'),
            ),
            //Linked in was  complaining about the header not including the Content-Length
            'header' => array(
                'Content-Length' => 0
            ),
        );

        $response = $this->HttpSocketOauth->request($request);

        // Redirect user to LinkedIn to authorize  my application
        parse_str($response, $response);
        //pr($response); die();
        //since the oauth_token_secret is not pass back with the callback url we need to store it in the Session
        //so that we can use it when we are signing the oauth_access_token request
        $this->Session->write('LinkedIn.oauth_token_secret', $response['oauth_token_secret']);
        $this->redirect('https://www.linkedin.com/uas/oauth/authenticate?oauth_token=' . $response['oauth_token']);
    }


    /**
     * The LinkedIn callback page. Takes the LinkedIn results and writes them to a session.
     * @return void
     * @access public
     */
    public function linkedin_callback()
    {
        
        $this->serviceConfiguration('LinkedIn', 3);
        
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

        $request1 = array(
            'uri' => array(
                'scheme' => 'http',
                'host' => 'api.linkedin.com',
                'path' => '/v1/people/~'
            ),
            'method' => 'GET',
            'auth' => array(
                'method' => 'OAuth',
                'oauth_consumer_key' => Configure::read('LinkedIn.consumer_key'),
                'oauth_consumer_secret' => Configure::read('LinkedIn.consumer_secret'),
                'oauth_token' => $response['oauth_token'],
                //'oauth_verifier' => $this->params['url']['oauth_verifier'],
                'oauth_token_secret' => $response['oauth_token_secret']
            ),
            'header' => array(
                'Content-Length' => 0
            ),
        );

        $response1 = $this->HttpSocketOauth->request($request1);

        parse_str($response1, $response1);


        $response1['user_id'] = $response1['amp;key'];
        
        /*
        $repsponse = array
        (
            'oauth_token' => 'some-fake-token',
            'oauth_token_secret' => 'some-fake-token-secret',
            'oauth_expires_in' => 0,
            'oauth_authorization_expires_in' => 0
        );
        */

        if($this->Session->check('Auth.User.id')){

            if($this->Oauth->doesOauthExist('linked_in', $response1['user_id'], $this->Session->read('Auth.User.id'))){

                $this->Aro->deleteAll(array('Aro.alias' => 'linked_in_'.$response1['user_id']));
                $this->Session->setFlash('You have been authenticated', 'success');
                $this->redirect($this->Auth->redirect());
            }else{
                $oauthUserId = $this->Oauth->oauthed('linked_in',
                                                    $response1['user_id'],
                                                    null,
                                                    $this->Session->read('Auth.User.id')
                                                );

                $this->__auth($oauthUserId, $response, 'LinkedIn');
            }

        }else{

            $oauthUserId = $this->Oauth->oauthed('linked_in', $response1['user_id']);
            $this->__auth($oauthUserId, $response, 'LinkedIn');
        }

    }

    /**
     * The Facebook connect page. Authorizes "this" application against a users Facebook account
     * @return void
     * @access public
     */
    public function facebook_connect()
    {

        $this->serviceConfiguration('Facebook', 3);
        
        $this->redirect("https://www.facebook.com/dialog/oauth?client_id=".Configure::read('Facebook.consumer_key')
                                                    ."&redirect_uri=".urlencode(Configure::read('Facebook.callback'))
                                                    ."&scope=read_stream,offline_access,publish_stream");

    }


    /**
     * The LinkedIn callback page. Takes the LinkedIn results and writes them to a session.
     * @return void
     * @access public
     */
    public function facebook_callback()
    {

        $this->serviceConfiguration('Facebook', 3);
        
        $token_url = "https://graph.facebook.com/oauth/access_token?"
        . "client_id=" . Configure::read('Facebook.consumer_key')
        . "&redirect_uri=" . urlencode(Configure::read('Facebook.callback'))
        . "&client_secret=" . Configure::read('Facebook.consumer_secret')
        . "&code=" . $this->params['url']['code'];

        $response = file_get_contents($token_url);
        $params = null;
        parse_str($response, $params);

        $graph_url = "https://graph.facebook.com/me?access_token="
        . $params['access_token'];

        $user = json_decode(file_get_contents($graph_url));

        if($this->Session->check('Auth.User.id')){

            if($this->Oauth->doesOauthExist('facebook', $user->id, $this->Session->read('Auth.User.id'))){

                $this->Aro->deleteAll(array('Aro.alias' => 'facebook_'.$user->id));
                $this->Session->setFlash('You have been authenticated', 'success');
                $this->redirect($this->Auth->redirect());
            }else{

                $oauthUserId = $this->Oauth->oauthed('facebook',
                                                    $user->id,
                                                    $params['access_token'],
                                                    $this->Session->read('Auth.User.id')
                                                );
                $this->__auth($oauthUserId, $response, 'Facebook');
            }

        }else{

            $oauthUserId = $this->Oauth->oauthed('facebook', $user->id, $params['access_token']);
            $this->__auth($oauthUserId, $response, 'Facebook');
        }

    }

    /**
     * Handels exceptions for misconfigured services
     * @param type $service
     * @param type $configCount 
     * @return void
     * @access public
     */
    public function serviceConfiguration($service, $configCount = null){
        
        $config = Configure::read();
            
        foreach($config[$service]['Schema'] as $key => $value){
            
            //Does the value exist?
            if(isset($config[$service][$key] )){
                
                //Do we have any validation rules set against the configiuration variable
                if(isset($config[$service]['Schema'][$key]['validate'])){

                    //Yes, loop through the validation rules and look for trouble
                    foreach($config[$service]['Schema'][$key]['validate'] as $rule){

                        //Will the validation fail?
                        if( !Validation::$rule($config[$service][$key]) ){
                            
                            //Yes, the validation failed, throw an exception
                            if($config['debug'] == 0){ //Production exception
                                throw new NotFoundException();
                            }else{ //Dev exception                            
                                $message = __("{$key} violates the {$rule} rule set");
                                $this->Session->setFlash($message, 'error');
                                throw new MethodNotAllowedException($message);
                            }
                        }
                    }
                }

            }else{
                //No, the configuration value is not set, throw an exception
                if($config['debug'] == 0){  //Production exception
                    throw new NotFoundException();
                }else{ //Dev exception
                    $message = __("{$key} has not been set");
                    $this->Session->setFlash($message, 'error');
                    throw new MethodNotAllowedException($message);
                }
            }
        }
        
    }
    
    /**
     * A wrapper for common authentication and session functionality
     * @param type $userId
     * @param type $response
     * @param type $key
     * @todo Generalize this with User::login()
     * @todo make use of or remove $error
     */
    private function __auth($userId, $response, $oauthKey)
    {


        $user = $this->User->getUser($userId);

        if(empty($user)){

            $this->log("User not found {$user['User']['username']}", 'weekly_user_login');
            return false;
        }else{

            if($this->Auth->login($user['User'])){

                $session = $this->Session->read('Auth');
                $oauthData = array($oauthKey => $response);

                $this->Session->write('Auth', array_merge($session, $oauthData));

                $this->__createAro($user['User']['username'], $user['User']['id']);

                $this->Access->permissions($user['User']);

                $this->Session->setFlash('You have been authenticated', 'success');
                $this->redirect($this->Auth->redirect());


            }else{
                return false;
            }

        }

    }

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