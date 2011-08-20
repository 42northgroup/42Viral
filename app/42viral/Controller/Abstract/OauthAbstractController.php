<?php

App::uses('AppController', 'Controller');
App::uses('HttpSocketOauth', 'Lib');

/**
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


    /**
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();
        
        $this->Auth->allow('*');

    }

    /**
     * The Twitter connect page. Authorizes "this" application against a users Twitter account
     * @author Neil Crookes <http://www.neilcrookes.com/>
     * @link http://www.neilcrookes.com/2010/04/12/cakephp-oauth-extension-to-httpsocket/
     * @return void
     * @access public
     */
    public function twitter_connect()
    {
        // Get a request token from twitter

        $Http = new HttpSocketOauth();

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

        $response = $Http->request($request);
        // Redirect user to twitter to authorize  my application
        parse_str($response, $response);
        $this->redirect('http://api.twitter.com/oauth/authorize?oauth_token=' . $response['oauth_token']);
    }   

    /**
     * The Twitter callback page. Takes the twitter results and writes them to a session.
     * @author Neil Crookes <http://www.neilcrookes.com/>
     * @link http://www.neilcrookes.com/2010/04/12/cakephp-oauth-extension-to-httpsocket/
     * @return void
     * @access public
     */
    public function twitter_callback()
    {

        $Http = new HttpSocketOauth();

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

        $response = $Http->request($request);
        parse_str($response, $response);
        // Save data in $response to database or session as it contains the access token and access token secret that you'll 
        // need later to interact with the twitter API
        $this->Session->write('Twitter', $response);

    } 
}