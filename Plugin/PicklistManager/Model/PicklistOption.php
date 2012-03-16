<?php
/**
 * Copyright 2012, Zubin Khavarian (http://zubink.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, Zubin Khavarian (http://zubink.com)
 * @link http://zubink.com
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppModel', 'Model');

/**
 * Picklist options model class which deals with managring picklist option for picklists. Manages basic CRUD and more.
 *
 * @package Plugin.PicklistManager
 * @subpackage Plugin.PicklistManager.Model
 * @author Zubin Khavarian
 */
class PicklistOption extends PicklistManagerAppModel
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