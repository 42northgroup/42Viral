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
App::uses('Scrubable', 'Lib');
App::uses('ProfileUtility', 'Lib');
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
            // I thought the default of x minutes was making the system a bit unusable. Do we think this setting is to
            // permissive?
            'csrfExpires' => '+1 day'
        ),
        'Session'
    );

    /**
     * Application-wide helpers
     *
     * @access public
     * @var array
     */
    public $helpers = array(
        'Asset',
        'Form',
        'Html',
        'Menu',
        'Paginator',
        'Session',
        'SocialMedia',
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
        $this->Security->blackHoleCallback = 'blackHoleHandler';
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
     * Security blackhole callback method for security error handling.
     *
     * @param $type string - Error type.
     * @access public
     */
    public function blackHoleHandler($type) {
        if(Configure::read('debug') > 0) {
            echo '<h2>' . pr($type) . '</h2>';
            exit;
        }
        else {
            $this->response->statusCode(403);
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
            $this->loadModel('Notification');
            $userId = $this->Session->read('Auth.User.id');

            $unreadMessageCount = $this->Notification->find(
                'count',
                array(
                    'conditions'=>array(
                        'Notification.person_id'=>$userId,
                        'Notification.marked'=>'unread'
                    ),
                    'contain'=>array()
                )
            );
            $this->set('unreadMessageCount', $unreadMessageCount);
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
                        throw new ForbiddenException(__('You can\'t do that!'));
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
     * Returns true if a target asset can be found in the Authenticated session
     * @param string $assetId
     * @param string $asset
     * @throws ForbiddenException
     * @return boolean
     */
    protected function _mine($assetId, $asset = 'Auth.User.id'){

        $deny = true;

        if($this->Session->read($asset) == $assetId){
            $deny = false;
        }

        if($deny){
            throw new ForbiddenException(__('The data you are trying to access does not belong to you!'));
        }

        return true;
    }

    /**
     * Throws a 400 Error if an association record does not exist.
     * A common use case is assuring a parent record exists to prevent creation of orphaned records.
     * 	Example - Creating an address against a Person would require matching Person.id record prior to creation
     *
     * @param string $model - pass as ModelName or model_name
     * @param string $modelId
     * @throws forbiddenException
     * @return string
     */
    protected function _validAssociation($model, $modelId){

        if(stripos($model, '-') !== false){
            $pluginModel = explode('-', $model);
            $modelToLoad = Inflector::classify($pluginModel[0]).'.'.Inflector::classify($pluginModel[1]);
            $modelToQuerry = Inflector::classify($pluginModel[1]);
        }else{
            $classifiedModel = Inflector::classify($model);
            $modelToLoad = $classifiedModel;
            $modelToQuerry = $classifiedModel;
        }

    	//Does the entitiy to which we want to attach the address exist? If not throw a 403 error.
    	$this->loadModel($modelToLoad);
    	$association = $this->$modelToQuerry->find('first',
	    		array(
		    		'conditions'=>array(
		    			"{$modelToQuerry}.id"=>$modelId
	    			),
	    			'contain'=>array(),
	    			'fields'=>array("{$modelToQuerry}.id")
    			)
    		);

		if(empty($association)){
    		throw new BadRequestException(__('The requested association does not exist!'));
    	}

    	return $modelToQuerry;
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
    	$record = $this->$classifiedModel->find('first',
	    		array(
		    		'conditions'=>array(
		    			"{$classifiedModel}.{$column}"=>$modelId
	    			),
	    			'contain'=>array(),
	    			'fields'=>array("{$classifiedModel}.{$column}")
    			)
    		);

		if(empty($record)){
    		throw new NotFoundException(__('The requested record does not exist!'));
    	}

    	return $classifiedModel;
    }

    /**
     * Throws a 404 Error if a result set returns false. This serves the same purpose as _validRecord, but will save
     * a query when dealing with read only (non-destructive) actions
     * @param string $model - pass as ModelName or model_name
     * @param string $modelId
     * @param string column
     * @throws notFoundException
     * @return string
     */
    protected function _isResultSet($data){
        if(empty($data)){
            throw new NotFoundException(__('The requested record does not exist!'));
        }
        return true;
    }

    /**
     * Provides functionality for auto-populating $title_for_layout
     * @access protected
     * @param string $fixedTitle
     * @param string $model
     * @param string $modelId
     */
    protected function _autoPageTitle($fixedTitle, $model, $modelId){

        $titleForLayout = null;

        switch($model){
            case 'Person':
                $this->loadModel($model);
                $person = $this->Person->find(
                    'first',
                    array(
                        'conditions'=>array(
                            'Person.id'=>$modelId
                        ),
                        'fields'=>array(
                            'Person.name',
                            'Person.username'
                        )
                    )
                );

                $titleForLayout = ProfileUtility::name($person['Person']) . $fixedTitle;
            break;

            default:

                $parsedModel = $this->_classifyModel($model);

                //If the model belongs to a plugin, checkout the plugin for the autoPageTitle() method
                if($parsedModel['isPlugin']){
                    App::import('Controller', $parsedModel['fullString']);
                    eval('$class = new ' . $parsedModel['pluginClassString'] . 'AppController();');
                    $title = $class->autoPageTitle($fixedTitle, $parsedModel['fullString'], $modelId);
                    $titleForLayout = $title;
                }

            break;
        }

        $this->set('title_for_layout', $titleForLayout);

    }

    /**
     * Returns a Plugin and Classified Model if applicable, else it just return a ClassifiedModel
     * @access protected
     * @param string $model
     * @return array
     */
    protected function _classifyModel($model){
        $plugin = null;
        $classifiedModel = null;
        $pluginClass = null;
        $fullString = null;
        $isPlugin = false;

        $chunks = explode('-', $model);

        if(count($chunks) > 1){

            $plugin = $chunks[0];
            $pluginClass = Inflector::classify($plugin);
            $classifiedModel = Inflector::classify($chunks[1]);
            $fullString = "{$pluginClass}.{$classifiedModel}";
            $isPlugin = true;

        }else{

            $classifiedModel = Inflector::classify($classifiedModel);

        }

        return array(
            'pluginString' => $plugin,
            'pluginClassString' => $pluginClass,
            'modelString' => $classifiedModel,
            'fullString' => $fullString,
            'isPlugin' => $isPlugin
        );
    }

}