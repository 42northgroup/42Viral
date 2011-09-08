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


App::uses('Tweet', 'Model');
App::uses('Linkedin', 'Model');
App::uses('Facebook', 'Model');
App::uses('Controller', 'Controller');

/**
 * Component class to use for fetching Oauth access tokens
 *
 * @author Lyubomir R Dimov <lrdimov@yahoo.com>
 */

class OauthsComponent  extends Component
{
    
    var $components = array('Session'); 

    public function __construct(ComponentCollection $collection, $settings = array())
    {
        parent::__construct($collection, $settings);

        $this->Tweet = new Tweet();
        $this->Linkedin = new Linkedin();
        $this->Facebook = new Facebook();
        $this->Controller = new Controller();
    }
    
    /**
     * Check if there is a token stored in the Session and calls the 
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
                    $this->Controller->redirect('/oauth/facebook_connect/');
                }
                
                break;
                
            case 'twitter':
                
                if( $this->Session->check('Twitter.oauth_token') ){
                    return true;
                }else{
                    $this->Session->write('Auth.redirect', '/'.$redirect_url);
                    $this->Controller->redirect('/oauth/twitter_connect/');
                }
                
                break;
                
            case 'linked_in':
                
                if( $this->Session->check('LinkedIn.oauth_token') ){                    
                    return true;
                }else{                    
                    $this->Session->write('Auth.redirect', '/'.$redirect_url);
                    $this->Controller->redirect('/oauth/linkedin_connect/');
                }
                
                break;
        }
    }

    
}