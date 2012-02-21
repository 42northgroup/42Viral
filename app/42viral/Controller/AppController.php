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
 * @author Jason D Snider <jason.snider@42viral.org>
 */
class AppController extends Controller
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
    public $helpers = array('Access', 'Asset', 'Form', 'Html', 'Member', 'Session', 'Text');
    
    //public $uses = array('AuditLog.Audit', 'AuditLog.AuditDelta');
    
    /**
     * The location of setup log files
     * @var string
     * @access public
     */    
    protected $_logDirectory = '';
    
    public function __construct($request = null, $response = null) {
        parent::__construct($request, $response);
        $this->_logDirectory = ROOT . DS . APP_DIR . DS . 'Config' . DS . 'Log' . DS;
    }
    
    /**
     * Fires before AppController
     * This is a good place for loading data and running security checks
     * @access public
     */
    public function beforeFilter()
    {        
        $this->Auth->deny('*');
        
        //Force a central login (1 login per prefix by default). 
        $this->Auth->loginAction = array('admin' => false, 'controller' => 'users', 'action' => 'login'); 
        
        $this->set('mine', false);
        
        if(isset($this->params['named']['language'])){
            $this->Session->write('Config.language', $this->params['named']['language']);
        }
        
        
        //If the setup isn't complete, force it to be completed
        if(!in_array('setup.txt', $this->_fetchLogs())){
            if($this->request->params['controller'] != 'setup'){
                $this->Session->setFlash('The system needs to be configured!');
                $this->redirect('/install.php');
            }
        }
        
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

        //Fetch the unread message count for current user's message inbox
        $this->loadModel('InboxMessage');
        $userId = $this->Session->read('Auth.User.id');
        $unreadMessageCount = $this->InboxMessage->findPersonUnreadMessageCount($userId);
        $this->set('unread_message_count', $unreadMessageCount);

    }
    
    /**
     * Creates a new log file when a setup step has been completed
     * @param string $log
     * @return void 
     * @access private
     */
    protected function _setupLog($log){
        file_put_contents ($this->_logDirectory . "{$log}.txt", date('Y-m-d H:i:s'));    
    }
    
    /**
     * Returns a list of created setup logs (i.e. completed steps)
     * @return array
     * @access private
     */
    protected function _fetchLogs(){
        return scandir($this->_logDirectory);
    }
    
    /**
     * Allows or denies access based on ACLs, Active Sessions and the explicit setting of public controllers and actions
     * @param array $allow 
     * @return void
     * @access public
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
                    //Deny access.
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