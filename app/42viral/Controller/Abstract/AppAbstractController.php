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
App::uses('Controller', 'Controller');
App::uses('File', 'Utility');
App::uses('Scrub', 'Lib');
/**
 *
 */
abstract class AppAbstractController extends Controller
{
    /**
     * Application wide components
     * @var type
     * @access public
     */

    public $components = array('Acl', 'Auth', 'RequestHandler', 'Security', 'Session');

    /**
     * Application-wide helpers
     * @var array
     * @access public
     */
    public $helpers = array('Access', 'Asset', 'Form', 'Html', 'Session', 'Text');

    /**
     * Fires before AppController
     * This is a good place for loading data and running security checks
     * @access public
     */
    public function beforeFilter()
    {     
        $this->Auth->deny('*');
        
    }
    
    /**
     * Fires after AppController but before the action
     * This is a good place for calling themes
     * @access public
     */
    public function beforeRender()
    {
        $this->viewClass = 'Theme';
        $this->theme = Configure::read('Theme.set');
    }
    
    /**
     * Allows or denies access based on ACLs, Active Sessions and the explicit setting of public controllers and actions
     * @param array $allow 
     * @return void
     * @access public
     * @author Jason D Snider <jsnider77@gmail.com>
     */
    public function auth($allow = array()){
        
        $allowAll = false;
        
        //Allow all = true denotes a public controller
        if(!empty($allow)){
            if($allow[0]=='*'){
                $allowAll = true;
            }
        }
        
        //Is this a public controller?
        if(!$allowAll){
            
            //No, this is not a public controller. 
            //Is this a public action?
            if(!in_array($this->request->params['action'], $allow)){
                //No, this in not a public action. 
                //Is the user logged in?
                if($this->Session->check('Auth.User.id')){
                    //Yes, the user is logged in.
                    //Does the user have access to this Controller-action?
                    if(!$this->Acl->check($this->Session->read('Auth.User.username'), 

                                Inflector::camelize($this->request->params['controller']) 
                                        . '-' 
                                        . $this->request->params['action'],

                                '*'
                            )){
                        //No, the user does not have access; bounce them out.
                        $this->Session->setFlash('You can\'t do that!', 'error');
                        $this->redirect('/users/login', '401');
                    }

                }else{
                    //No, the user is not looked in; deny access.                    
                    $this->Session->write('Auth.post_comment', Scrub::htmlStrict($this->data['Conversation']['body']));
                    $this->Auth->deny($this->request->params['action']);
                }

            }else{
                //Yes, this is a public action; allow it.
                $this->Auth->allow($this->request->params['action']);
            }
        }else{
            //Yes, this is a public controller; allow the action.
            $this->Auth->allow($this->request->params['action']);
        }

    }
}