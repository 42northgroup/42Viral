<?php

App::uses('AppController', 'Controller');
App::uses('HttpSocketOauth', 'Lib');

/**
 * @author Jason D Snider <jsnider77@gmail.com>
 * @link http://www.neilcrookes.com/2010/04/12/cakephp-oauth-extension-to-httpsocket/
 * @package app
 * @subpackage app.core
 */
abstract class OauthAbstractController extends AppController 
{
    
    /**
     * This controller does not use a model
     *
     * @var array
     * @access public
     */
    public $uses = array('Oauth', 'People', 'User');
    
    public function __construct($request = null, $response = null) {
        parent::__construct($request, $response);
        // Get a request token from twitter
        $this->HttpSocketOauth = new HttpSocketOauth();
    }

    /**
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('*');
        
        $this->Auth->autoRedirect = true;
        $this->Auth->loginRedirect = array('controller' => 'members', 'action' => 'view');
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');        
    }

    /**
     * The Twitter connect page. Authorizes "this" application against a users Twitter account
     * @author Jason D Snider <jsnider77@gmail.com>
     * @author Neil Crookes <http://www.neilcrookes.com/>
     * @link http://www.neilcrookes.com/2010/04/12/cakephp-oauth-extension-to-httpsocket/
     * @return void
     * @access public
     */
    public function twitter_connect()
    { 

        $request = array(
            'uri' => array(
                'host' => 'api.twitter.com',
                'path' => '/oauth/request_token'
            ),
            'method' => 'GET',
            'auth' => array(
                'method' => 'OAuth',
                'oauth_callback' => '',
                'oauth_consumer_key' => Configure::read('Twitter.consumer_key'),
                'oauth_consumer_secret' => Configure::read('Twitter.consumer_secret')       
            )
        );

        $response = $this->HttpSocketOauth ->request($request);
        // Redirect user to twitter to authorize  my application
        parse_str($response, $response);
        $this->redirect('http://api.twitter.com/oauth/authorize?oauth_token=' . $response['oauth_token']);

    }   

    /**
     * The Twitter callback page. Takes the Twitter results and writes them to a session.
     * @author Jason D Snider <jsnider77@gmail.com>
     * @author Neil Crookes <http://www.neilcrookes.com/>
     * @link http://www.neilcrookes.com/2010/04/12/cakephp-oauth-extension-to-httpsocket/
     * @return void
     * @access public
     */
    public function twitter_callback()
    {
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
        $oauthUserId = $this->Oauth->oauthed('twitter', $response['user_id'], 'Twitter');
        $this->__auth($oauthUserId, $response, 'Twitter'); 
    } 

    /**
     * The LinkedIn connect page. Authorizes "this" application against a users LinkedIn account
     * @see http://www.slideshare.net/episod/linkedin-oauth-zero-to-hero for oauth_token_secret
     * @author Jason D Snider <jsnider77@gmail.com>
     * @author Neil Crookes <http://www.neilcrookes.com/>
     * @link http://www.neilcrookes.com/2010/04/12/cakephp-oauth-extension-to-httpsocket/
     * @return void
     * @access public
     */
    public function linkedin_connect()
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
     * @author Jason D Snider <jsnider77@gmail.com>
     * @author Lyubomir R Dimov <ldimov@microtrain.net>
     * @author Neil Crookes <http://www.neilcrookes.com/>
     * @link http://www.neilcrookes.com/2010/04/12/cakephp-oauth-extension-to-httpsocket/
     * @return void
     * @access public
     * @todo How do we get a unique identifier to tie this to a person?
     */
    public function linkedin_callback()
    {        
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
        
        //pr($response);
        
        /*
        $repsponse = array
        (
            'oauth_token' => 'some-fake-token',
            'oauth_token_secret' => 'some-fake-token-secret',
            'oauth_expires_in' => 0,
            'oauth_authorization_expires_in' => 0
        );
        */
        
        $oauthUserId = $this->Oauth->oauthed('linked_in', $response['user_id'], 'LinkedIn');
        $this->__auth($oauthUserId, $response, 'LinkedIn'); 
        
    } 
    
    /**
     * A wrapper for common authentication and session functionality
     * @param type $userId
     * @param type $response
     * @param type $key 
     * @todo Generalize this with User::login()
     * @todo make use of or remove $error
     */
    public function __auth($userId, $response, $oauthKey){


        $user = $this->User->getUser($userId);
        
        if(empty($user)){
            $this->log("User not found {$user['User']['username']}", 'weekly_user_login');
            $error = true;
        }else{

            $hash = Sec::hashPassword(Configure::read('Oauth.password'), $user['User']['salt']);
            if($hash == $user['User']['password']){

                if($this->Auth->login($user['User'])){
                    
                    $session = $this->Session->read('Auth');
                    $oauthData = array($oauthKey => $response);

                    $this->Session->write('Auth', array_merge($session, $oauthData));
                    
                    $this->Session->setFlash('You have been authenticated', 'success');
                    $this->redirect($this->Auth->redirect());

                    $error = false;
                }else{
                    $error = true;
                }

            }else{
                $this->log("Password mismatch {$this->data['User']['username']}", 'weekly_user_login');
                $error = true;
            }
        }      
  
    }
    
}