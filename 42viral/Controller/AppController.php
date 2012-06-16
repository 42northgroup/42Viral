<?php
/**
 * 42Viral's parent controller layer
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package 42viral
 */

App::uses('Controller', 'Controller');
App::uses('File', 'Utility');
App::uses('ContentFilters.Scrubable', 'Lib');
/**
 * 42Viral's parent controller layer
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @package 42viral
 */
class AppController extends Controller
{

    /**
     * Application wide components
     * @var array
     * @access public
     */
    public $components = array(
        'Acl',
        'Auth',
        'RequestHandler',
        'Security' => array(
            'csrfExpires' => '+1 day'
        ),
        'Session');
    /**
     * Application-wide helpers
     *
     * @access public
     * @var array
     */
    public $helpers = array(
        'AssetManager.Asset',
        'Connect.SocialMedia',
        'Form',
        'Html',
        'Paginator',
        'Profile',
        'Session',
        'Text'
    );


    /**
     * The parent constructor for all 42Viral controllers
     *
     * @access public
     * @param object $request
     * @param object $response
     */
    public function __construct($request = null, $response = null)
    {
        parent::__construct($request, $response);
    }

    /**
     * Fires before AppController
     * This is a good place for loading data and running security checks
     * @access public
     */
    public function beforeFilter()
    {
        //If the setup isn't complete, force it to be completed
        if (!isSetupComplete()) {
            $this->redirect('/install.php');
        }

        $this->Auth->deny('*');

        //Force a central login (1 login per prefix by default).
        $this->Auth->loginAction = array(
            'admin' => false,
            'plugin' => false,
            'controller' => 'users',
            'action' => 'login'
        );

        $this->set('mine', false);

        if (isset($this->params['named']['language'])) {
            $this->Session->write('Config.language', $this->params['named']['language']);
        }

        //test for an expired password
        if ($this->Session->check("Auth.User")) {
            $passwordExpiration = Configure::read('Password.expiration');
            if (!empty($passwordExpiration)) {
                if ($this->Session->read("Auth.User.password_expires") < date("Y-m-d H:i:s")) {
                    if (!in_array($this->request->params['action'], array('change_password', 'logout'))) {
                        $this->Session->setFlash(__('Your password has expired'), 'error');
                        $this->redirect('/users/change_password');
                    }
                }
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
        if (!is_null($this->Session->read('Auth.User'))) {
            $this->loadModel('InboxMessage');
            $userId = $this->Session->read('Auth.User.id');
            $unreadMessageCount = $this->InboxMessage->findPersonUnreadMessageCount($userId);
            $this->set('unread_message_count', $unreadMessageCount);
        }

    }

    /**
     * Allows or denies access based on ACLs, Active Sessions and the explicit setting of public controllers and actions
     * @access public
     * @param array $allow
     */
    public function auth($allow = array())
    {

        $allowAll = false;

        //Allow all = true denotes a public controller
        if (!empty($allow)) {
            if ($allow[0] == '*') {
                $allowAll = true;
            }
        }

        //Is this a public controller?
        if (!$allowAll) {

            //No, this is not a public controller.
            //Is this a public action?
            if (!in_array($this->request->params['action'], $allow)) {
                //No, this in not a public action.
                //Is the user logged in?
                if ($this->Session->check('Auth.User.id')) {
                    //Yes, the user is logged in.
                    //Does the user have access to this Controller-action?
                    if (!$this->Acl->check($this->Session->read('Auth.User.username'),
                                    Inflector::camelize($this->request->params['controller'])
                                    . '-'
                                    . $this->request->params['action'], '*'
                    )) {
                        //No, the user does not have access; bounce them out.
                        $this->Session->setFlash('You can\'t do that!', 'error');
                        $this->redirect('/users/login', '401');
                    }
                } else {
                    //Deny access.
                    $this->Auth->deny($this->request->params['action']);
                }
            } else {
                //Yes, this is a public action; allow it.
                $this->Auth->allow($this->request->params['action']);
            }
        } else {
            //Yes, this is a public controller; allow the action.
            $this->Auth->allow($this->request->params['action']);
        }
    }

    /**
     * Throws an 403 error if you try to modify data that does not belong to you.
     * Belonging to you is defined as an asset with a direct association to your Person or Profile record
     *
     * @param string $againstId
     * @param string $model - pass as ModelName or model_name
     * @param string $modelId
     * @throws ForbiddenException
     * @return string
     */
    protected function _grantAccess($againstId, $model, $modelId){
    	$classifiedModel = Inflector::classify($model);
		$deny = true;

		if(in_array($classifiedModel, array('Person', 'Profile'))){
			if($againstId == $modelId){
				$deny = false;
			}
		}

		if($deny){
			throw new ForbiddenException(__('The data you are trying to modify does not belong to you!'));
		}

		return $classifiedModel;
    }

    /**
     * Throws a 400 Error if a association record does not exist.
     * A common use case is assuring a parent record exists to prevent creation of orphaned records.
     * 	Example - Creating an address against a Person would require matching Person.id record prior to creation
     * @param string $model - pass as ModelName or model_name
     * @param string $modelId
     * @throws forbiddenException
     * @return string
     */
    protected function _validAssociation($model, $modelId){

    	$classifiedModel = Inflector::classify($model);

    	//Does the entitiy to which we want to attach the address exist? If not throw a 403 error.
    	$this->loadModel($classifiedModel);
    	$association = $this->$classifiedModel->find('first',
	    		array(
		    		'conditions'=>array(
		    			"{$classifiedModel}.id"=>$modelId
	    			),
	    			'contain'=>array(),
	    			'fields'=>array("{$classifiedModel}.id")
    			)
    		);

		if(empty($association)){
    		throw new BadRequestException(__('The requested association does not exist!'));
    	}

    	return $classifiedModel;
    }

	/**
	 * Throws a 404 Error if a requested record does not exist
	 * A good use case making sure a record exists prior to editing or creating a view.
	 * @param string $model - pass as ModelName or model_name
	 * @param string $modelId
	 * @param string column
	 * @throws notFoundException
	 * @return string
	 */
	protected function _validRecord($model, $modelId, $column = 'id'){

    	$classifiedModel = Inflector::classify($model);

    	//Does the entitiy to which we want to attach the address exist? If not throw a 403 error.
    	$this->loadModel($classifiedModel);
    	$association = $this->$classifiedModel->find('first',
	    		array(
		    		'conditions'=>array(
		    			"{$classifiedModel}.{$column}"=>$modelId
	    			),
	    			'contain'=>array(),
	    			'fields'=>array("{$classifiedModel}.{$column}")
    			)
    		);

		if(empty($association)){
    		throw new NotFoundException(__('The requested record does not exist!'));
    	}

    	return $classifiedModel;
    }

    /**
     * Initialize doc upload settings upon request for given model
     *
     * @access public
     * @param string $modelName (Default = null)
     */
    public function prepareDocUpload($modelName=null)
    {
        $this->FileUpload->fileModel = $modelName;
        $this->FileUpload->skipModel = true;
        $this->FileUpload->fileVar = 'body_content_file';
        $this->FileUpload->uploadDir = 'files/temp';
        $this->FileUpload->allowedTypes = array(
            //Doc
            'application/doc',
            'application/msword',
            'application/msword-doc',
            'application/vnd.msword',
            'application/winword',
            'application/word',
            'application/x-msw6',
            'application/x-msword',
            'application/x-msword-doc',

            //DocX
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.openxmlformats-officedocument.word',
            'application/vnd.ms-word.document.12',

            //PDF
            'application/acrobat',
            'application/nappdf',
            'application/x-pdf',
            'application/vnd.pdf',
            'text/pdf',
            'text/x-pdf'
        );
    }

}