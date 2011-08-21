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
    public $uses = array();
    
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
        $response = parse_str($response, $response);
        
        // Save data in $response to database or session as it contains the access token and access token secret that 
        // you'll need later to interact with the twitter API
        $this->Session->write('Auth.Twitter', $response);
    } 

    /**
     * The LinkedIn connect page. Authorizes "this" application against a users LinkedIn account
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
            'oauth_nonce'=>sha1(microtime()),
            'oauth_timestamp'=>time(),
            ),
            //Linked in was  complaining about the header not including the Content-Length
            'header' => array(
                'Content-Length' => 0
            ),
        );

        $response = $this->HttpSocketOauth->request($request);

        // Redirect user to LinkedIn to authorize  my application
        parse_str($response, $response);
        //$this->redirect('https://www.linkedin.com/uas/oauth/authorize');
        $this->redirect('https://www.linkedin.com/uas/oauth/authorize?oauth_token=' . $response['oauth_token']);
    }  
    

    /**
     * The LinkedIn callback page. Takes the LinkedIn results and writes them to a session.
     * @author Jason D Snider <jsnider77@gmail.com>
     * @author Neil Crookes <http://www.neilcrookes.com/>
     * @link http://www.neilcrookes.com/2010/04/12/cakephp-oauth-extension-to-httpsocket/
     * @return void
     * @access public
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
                'oauth_nonce'=>sha1(microtime()),
                'oauth_timestamp'=>time(),                
            ),
            'header' => array(
                'Content-Length' => 0
            ),
        );

        $response = $this->HttpSocketOauth->request($request);
        $response = parse_str($response, $response);
        
        // Save data in $response to database or session as it contains the access token and access token secret that 
        // you'll need later to interact with the LinkedIn API
        $this->Session->write('LinkedIn', $response);
    } 
    
 
    
}