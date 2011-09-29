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

/**
 * 
 */
abstract class PicklistsAbstractController extends AppController
{

    /**
     * @var array
     * @access public
     */
    //public $helpers = array();

    /**
     * @var array
     * @access public
     */
    public $uses = array('Picklist', 'PicklistOption');

    
    /**
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
    }


    /**
     *
     */
    public function admin_index()
    {

        $picklist = $this->Picklist->fetchPicklist('activities', array(
            //'categoryFilter' => 'user_group',
            'grouped' => false,
            //'grouped' => true
        ));

        $this->set('picklist', $picklist);
    }
}
