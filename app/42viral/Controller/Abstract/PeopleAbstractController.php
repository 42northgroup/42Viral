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

//App::uses('ProfileAbstract', 'AbstractModel');
//App::uses('CompanyAbstract', 'AbstractModel');
//App::uses('OauthAbstract', 'AbstractModel');

/**
 * @package app
 * @subpackage app.core
 * @author Jason D Snider <jsnider77@gmail.com>
 */
abstract class PeopleAbstractController extends AppController
{

    /**
     * @var array
     * @access public
     */

    public $uses = array('Person');

    /**
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();
    }

    public function admin_index()
    {
        $people = $this->Person->find('all');
        $this->set('people', $people);
    }    
    
   public function admin_view($username){
       $person = $this->Person->fetchPersonWith($username);
       $this->set('person', $person);
   }
}