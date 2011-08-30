<?php

App::uses('Controller', 'Controller');
App::uses('File', 'Utility');

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
    public $helpers = array('Asset', 'Auth', 'Form', 'Html', 'Session', 'Text');

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