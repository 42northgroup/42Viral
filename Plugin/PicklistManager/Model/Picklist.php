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
 * Picklist model class which deals with picklist generation and fetching operations
 *
 * @package Plugin.PicklistManager
 * @subpackage Plugin.PicklistManager.Model
 * @author Zubin Khavarian
 */
class Picklist extends PicklistManagerAppModel
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
        
        $this->virtualFields = array(
            'delete_url' => "CONCAT('/admin/picklists/delete/',`{$this->alias}`.`id`)",
            'edit_url' => "CONCAT('/admin/picklists/edit/',`{$this->alias}`.`id`)"
        );        
    }


    /**
     * Fetch all picklists sorted by names in ascending order
     *
     * @access public
     * @return array
     */
    public function fetchAllPicklists()
    {
        $picklists = $this->find('all', array(
            'contain' => array(),
            'fields' => array(
                'Picklist.id',
                'Picklist.alias',
                'Picklist.name',
                'Picklist.active'
            ),

            'order' => array(
                'Picklist.name ASC'
            )
        ));

        return $picklists;
    }


    /**
     * Fetch a single picklist using its id
     *
     * @access public
     * @param string $picklistId
     * @return Picklist
     */
    public function fetchPicklist($picklistId)
    {
        $picklist = $this->find('first', array(
            'contain' => array(),

            'conditions' => array(
                'Picklist.id' => $picklistId
            ),

            'order' => array(
                'Picklist.name ASC'
            )
        ));

        return $picklist;
    }


    /**
     * Fetch a single picklist using its id with all the attached picklist options
     *
     * @access public
     * @param string $picklistId
     * @return Picklist
     */
    public function fetchPicklistWithOptions($picklistId)
    {
        $picklist = $this->find('first', array(
            'contain' => array(
                'PicklistOption' => array(
                    'order' => array(
                        'PicklistOption.category ASC',
                        'PicklistOption.group ASC',
                        'PicklistOption.pl_value ASC'
                    )
                )
            ),

            'conditions' => array(
                'Picklist.id' => $picklistId
            ),

            'order' => array(
                'Picklist.name ASC'
            )
        ));

        return $picklist;
    }


    /**
     * Given a picklist id fetch the picklist and extract the picklist alias
     *
     * @access public
     * @param string $picklistId
     * @return string
     */
    public function getPicklistAlias($picklistId)
    {
        $picklist = $this->find('first', array(
            'contain' => array(),

            'conditions' => array(
                'Picklist.id' => $picklistId
            ),

            'fields' => array(
                'Picklist.alias'
            )
        ));

        $alias = '';

        if(!empty($picklist)) {
            $alias = $picklist['Picklist']['alias'];
        }

        return $alias;
    }


    /**
     * Delete a given picklist and all its associated picklist options
     *
     * @access public
     * @param string $picklistId
     * @return boolean
     */
    public function deletePicklist($picklistId)
    {
        $opStatus = $this->delete($picklistId, true);

        if($opStatus) {
            return true;
        } else {
            return false;
        }
    }

    
    /**
     * Fetches a picklist using its alias handle with different filtering and formatting options provided by the
     * $options parameter.
     *
     * @access public
     * @param string $picklistAlias
     * @param array $options
     * @param boolean $grouped
     * @return Picklist
     *
     * @example
     * 
     * 1:  $this->Picklist->fetchPicklistOptions('some_picklist');
     *
     * 2:  $this->Picklist->fetchPicklistOptions('some_picklist', array(
     *         'grouped' => true
     *     ));
     *
     * 3:  $this->Picklist->fetchPicklistOptions('some_picklist', array(
     *         'grouped' => true,
     *         'categoryFilter' => 'functional_grouping',
     *         'emptyOption' => true,
     *         'otherOption' => true
     *     ));
     */
    public function fetchPicklistOptions($picklistAlias, $options=array())
    {

        //Initialize default options
        $categoryFilter = '';
        $grouped = false;
        $emptyOption = true;
        $otherOption = true;

        $allowedOptions = array('categoryFilter', 'grouped', 'emptyOption', 'otherOption');

        foreach($allowedOptions as $tempOption) {
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

        $list = $this->__buildList($picklist, $grouped, $emptyOption, $otherOption);

        return $list;
    }


    /**
     * Formats a queried picklist data structure to match the key=>value pair structure more suitable for the
     * CakePHP form helper.
     * 
     * @access private
     * @param array $inputList List of options from the database query
     * @param boolean $grouped Whether a grouped list should be generated or a flat list
     * @param boolean $emptyOption Whether the list should contain an empty option for default selection
     * @param boolean $otherOption Whether the list should contain an 'other' option
     * @return array
     */
    private function __buildList($inputList, $grouped, $emptyOption, $otherOption)
    {

        $outputList = array();

        //No options to build, bypass and just return an empty list
        if(empty($inputList['PicklistOption'])) {
            return $outputList;
        }

        //Inject empty option if request, at the top of the list
        if($emptyOption) {
            $outputList[''] = '';
        }

        if($grouped) {
            foreach($inputList['PicklistOption'] as $tempPlOption) {
                $outputList[$tempPlOption['group']][$tempPlOption['pl_key']] = $tempPlOption['pl_value'];
            }

            ksort($outputList); //Sort the grouped array based on group name which is the array key

        } else {
            foreach($inputList['PicklistOption'] as $tempPlOption) {
                $outputList[$tempPlOption['pl_key']] = $tempPlOption['pl_value'];
            }
        }

        //Inject 'other' option if requested, at the bottom of the list
        if($otherOption) {
            $outputList['other'] = 'Other';
        }
        
        return $outputList;
    }


}