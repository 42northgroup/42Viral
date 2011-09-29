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
 * 
 *
 * @package app
 * @subpackage app.core
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
class PicklistAbstract extends AppModel
{
    /**
     * @var string
     * @access public
     */
    public $name = 'Picklist';

    
    /**
     * @var array
     * @access public
     */
    public $validate = array();


    /**
     * @var array
     * @access public
     */
    public $hasMany = array(
        'PicklistOption' => array(
            'className' => 'PicklistOption',
            'foreignKey' => 'picklist_id',
            'dependent' => true
        )
    );


    /**
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
    }

    public $actsAs = array('Containable');

    /**
     * 
     *
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access public
     * @param string $picklistAlias
     * @param array $options
     * @param boolean $grouped
     * @return Picklist
     */
    public function fetchPicklist($picklistAlias, $options=array())
    {

        //Initialize default options
        $categoryFilter = '';
        $grouped = false;

        $optionList = array('categoryFilter', 'grouped');

        foreach($optionList as $tempOption) {
            if(isset($options[$tempOption])) {
                ${$tempOption} = $options[$tempOption];
            }
        }
        
        $plOpConditionsArray = array();
        $plOpConditionsArray['PicklistOption.active'] = true;
        if(!empty($categoryFilter) && is_string($categoryFilter)) {
            $plOpConditionsArray['PicklistOption.category'] = $categoryFilter;
        }

        $picklist = $this->find('first', array(
            'contain' => array(
                'PicklistOption' => array(
                    'conditions' => $plOpConditionsArray,
                    'order' => array(
                        'PicklistOption.pl_value ASC'
                    ),
                    'fields' => array(
                        'PicklistOption.pl_key', 
                        'PicklistOption.pl_value',
                        'PicklistOption.group'
                    )
                )
            ),

            'conditions' => array(
                'Picklist.alias' => $picklistAlias
            )
        ));

        $list = $this->__buildList($picklist, $grouped);

        return $list;
    }


    /**
     * 
     * 
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access private
     * @param array $inputList
     * @param boolean $grouped
     * @return array
     */
    private function __buildList($inputList, $grouped)
    {
        $outputList = array();

        if($grouped) {
            foreach($inputList['PicklistOption'] as $tempPlOption) {
                $outputList[$tempPlOption['group']][$tempPlOption['pl_key']] = $tempPlOption['pl_value'];
            }
        } else {
            foreach($inputList['PicklistOption'] as $tempPlOption) {
                $outputList[$tempPlOption['pl_key']] = $tempPlOption['pl_value'];
            }
        }
        
        return $outputList;
    }


}