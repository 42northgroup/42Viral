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
App::uses('Handy', 'Lib');
App::uses('Member', 'Lib');
/**
 *** @author Jason D Snider <jason.snider@42viral.org>
 */
 class ContentsController extends AppController {

    /**
     * Controller name
     * @var string
     * @access public
     */
    public $name = 'Contents';
    
    /**
     * This controller does not use a model
     * @var array
     * @access public
     */
    public $uses = array(
        'Blog', 
        'Content', 
        'Conversation', 
        'Oauth', 
        'Page', 
        'Person', 
        'PicklistManager.Picklist',
        'Post'
    );
    
    /**
     * @var array
     * @access public
     */
    public $components = array('File', 'Oauths');  
    
    /**
     * @var array
     * @access public
     */
    public $helpers = array('Member', 'Paginator');
    
    /**
     * @return void
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->auth(array('content', 'post_comment'));
    }
    
    /**
     * An action for promoting new content
     *
     * @return void
     * @access public
     */
    public function promote($id, $redirect_url='users/social_media')
    {
        
        if( !$this->Session->check('Auth.User.sm_list') ){
            
            $sm_list = $this->Oauth->find('list', array(
                'conditions' => array('Oauth.person_id' => $this->Session->read('Auth.User.id')),
                'fields' => array('Oauth.oauth_id', 'Oauth.service')
            ));

            $this->Session->write('Auth.User.sm_list', $sm_list);
        }
        
        foreach( $this->Session->read('Auth.User.sm_list') as $key => $val ){
            switch ($val){
                
                case 'facebook':
                    $this->Oauths->check_session_for_token('facebook', $redirect_url);
                    break;
                
                case 'linked_in':
                    $this->Oauths->check_session_for_token('linked_in', $redirect_url);
                    break;
                case 'twitter':
                    $this->Oauths->check_session_for_token('twitter', $redirect_url);
                    break;
            }
        }
        
        $content = $this->Content->findById($id);
        $this->set('content', $content);
        
        $objectType = strtolower($content['Content']['object_type']);

        $shorty = " " . Configure::read("Shorty.{$objectType}") . $content['Content']['short_cut'];

        
        $twitter = Handy::truncate($content['Content']['tease'] , (140 - strlen($shorty))) . $shorty;

        $other = $content['Content']['tease'] . " " . Configure::read('Domain.url') . $content['Content']['url'];
        
        $promo = array(
            'twitter'=>$twitter,
            'other'=>$other
        );
        
        $this->set('promo', $promo);

        $this->set('title_for_layout', "Promote {$content['Content']['name']}");
        
    }      
}