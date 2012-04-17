<?php
/**
 * PHP 5.3
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
 * @package       42viral\app
 */

App::uses('AppController', 'Controller');
/**
 * Manages UI tests for controllers
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 */
 class UiTestsController extends AppController
{

    /**
     * This controller does not use a model
     *
     * @var array
     * @access public
     */
    public $uses = array();


    /**
     * beforeFilter
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('*');
    }

    /**
     * beforeRender
     * @access public
     */
    public function beforeRender()
    {
        parent::beforeRender();
        $this->layout = 'qunit';
    }
    
    /**
     *
     * To be developed
     */
    public function index() 
    {

    }
    
    
    /**
     * To be developed
     */
    public function example() 
    {

    }

}
