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

App::uses('AppModel', 'Model');

/**
 * @package app
 * @subpackage app.core
 *
 *** @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
class PicklistOption extends AppModel
{
    /**
     * @var string
     * @access public
     */
    public $name = 'PicklistOption';

    
    /**
     * @var array
     * @access public
     */
    public $validate = array();


    /**
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Fetch a picklist option given its ID
     * 
     * @access public
     * @param string $picklistOptionId
     * @return PicklistOption
     */
    public function fetchPicklistOption($picklistOptionId)
    {
        $picklistOption = $this->find('first', array(
            'contain' => array(),

            'conditions' => array(
                'PicklistOption.id' => $picklistOptionId
            )
        ));

        return $picklistOption;
    }
}