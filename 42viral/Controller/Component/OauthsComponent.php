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
 * @package       42viral\app
 */
App::uses('Tweet', 'Connect.Model');
App::uses('Linkedin', 'Connect.Model');
App::uses('Facebook', 'Connect.Model');
App::uses('Controller', 'Controller');
/**
 * Component class to use for fetching Oauth access tokens
 *
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 */

class OauthsComponent  extends Component
{
    /**
     * Components
     * @access public
     * @var type
     */
    var $components = array('Session'); 

    
    /**
     * Checks if there is a token stored in the Session and calls the 
     * appropriate functions to store one if there isn't
     * 
     * @param string $service
     * @param string $redirect_url
     * @return boolean 
     */    
    public function check_session_for_token($service, $redirect_url)
    {
        switch ($service){
            case 'facebook':
                
                if( $this->Session->check('Facebook.oauth_token') ){
                    return true;
                }else{                
                    $this->Session->write('Auth.redirect', '/'.$redirect_url);
                    //$this->Controller->redirect('/oauth/facebook_connect/');
                    return false;
                }
                
                break;
                
            case 'google_plus':
                $expired = false;
                $token_expires = $this->Session->read('GooglePlus.oauth_expires');
                $token_created = $this->Session->read('GooglePlus.oauth_created');
                
                if( ($token_created + $token_expires) <= strtotime('now') ){
                    $expired = true;
                }

                if( $this->Session->check('GooglePlus.oauth_token') && ($expired == false) ){

                    return true;
                }else{                    
                    
                    $this->Session->write('Auth.redirect', '/'.$redirect_url);                    
                    return false;
                }                
                
                break;
                
            case 'twitter':
                
                if( $this->Session->check('Twitter.oauth_token') ){
                    return true;
                }else{
                    $this->Session->write('Auth.redirect', '/'.$redirect_url);
                    //$this->Controller->redirect('/oauth/twitter_connect/');
                    return false;
                }
                
                break;
                
            case 'linked_in':
                
                $expired = false;
                $token_expires = $this->Session->read('LinkedIn.oauth_expires');
                $token_created = $this->Session->read('LinkedIn.oauth_created');

                if( ($token_created + $token_expires) <= strtotime('now') ){
                    $expired = true;
                }

                if( $this->Session->check('LinkedIn.oauth_token') && ($expired == false) ){

                    return true;
                }else{                    
                    
                    $this->Session->write('Auth.redirect', '/'.$redirect_url);                    
                    //$this->Controller->redirect('/oauth/linkedin_connect/');
                    return false;
                }
                
                break;
        }
    }

    
}
