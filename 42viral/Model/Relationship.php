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
 * Mangages people's relationships
 *
 * @package app
 * @subpackage app.core
 *
 * @author Lyubomir R Dimov <lrdimov@yahoo.com>
 */
class Relationship extends AppModel
{
    /**
     * Model name
     * @var string
     * @access public
     */
    public $name = 'Relationship';

    public $belongsTo = array(
        'Person1' => array(
            'className' => 'Person',
            'foreignKey' => 'person1_id',
            'dependent' => false
        ),

        'Person2' => array(
            'className' => 'Person',
            'foreignKey' => 'person2_id',
            'dependent' => false
        )
    );

    /**
     * beofreSave
     * @access public
     */
    public function beforeSave()
    {
        parent::beforeSave();
    }

    public function fetchPersonRelationships($personId)
    {
        $relationships = $this->find('all', array(
            'conditions' => array(
                'OR' => array(
                    'Relationship.person1_id' => $personId,
                    'Relationship.person2_id' => $personId
                )
            )
        ));

        return $relationships;
    }

    public function fetchPersonRelationshipsList($personId, $with = array())
    {
        $relationships = $this->find('all', array(
            'conditions' => array(
                'AND' => array(
                    'OR' => array(
                        'Relationship.person1_id' => $personId,
                        'Relationship.person2_id' => $personId
                    ),
                    'OR' => array(
                        'Relationship.person1_id' => $with,
                        'Relationship.person2_id' => $with
                    )
                )
            )
        ));

        $count = count($relationships);

        for($i=0; $i < $count; $i++){
            if($relationships[$i]['Relationship']['person1_id'] == $personId){
                $relationships[$relationships[$i]['Relationship']['person2_id']] = $relationships[$i];
            }else{
                $relationships[$relationships[$i]['Relationship']['person1_id']] = $relationships[$i];
            }

            unset($relationships[$i]);
        }

        return $relationships;
    }

    public function fetchPersonRelationshipTypesList($personId, $with = array())
    {
        $relationships = $this->find('all', array(
            'conditions' => array(
                'OR' => array(
                    'Relationship.person1_id' => $personId,
                    'Relationship.person2_id' => $personId
                )
            )
        ));

        $filtered['followed'] = array();
        $filtered['following'] = array();
        $filtered['friends'] = array();
        $filtered['blocked'] = array();
        $filtered['blocking'] = array();
        $filtered['response_pending'] = array();
        $filtered['request_pending'] = array();

        $count = count($relationships);

        for($i=0; $i < $count; $i++){
            if($relationships[$i]['Relationship']['person1_id'] == $personId){
                if($relationships[$i]['Relationship']['person1_to_person2_follow'] == 1){
                    array_push($filtered['following'], $relationships[$i]);
                }

                if($relationships[$i]['Relationship']['person2_to_person1_follow'] == 1){
                    array_push($filtered['followed'], $relationships[$i]);
                }

                if($relationships[$i]['Relationship']['person1_to_person2_block'] == 1){
                    array_push($filtered['blocking'], $relationships[$i]);
                }

                if($relationships[$i]['Relationship']['person2_to_person1_block'] == 1){
                    array_push($filtered['blocked'], $relationships[$i]);
                }

                if($relationships[$i]['Relationship']['friends'] == 1){
                    array_push($filtered['friends'], $relationships[$i]);
                }
            }else{
                if($relationships[$i]['Relationship']['person2_to_person1_follow'] == 1){
                    array_push($filtered['following'], $relationships[$i]);
                }

                if($relationships[$i]['Relationship']['person1_to_person2_follow'] == 1){
                    array_push($filtered['followed'], $relationships[$i]);
                }

                if($relationships[$i]['Relationship']['person2_to_person1_block'] == 1){
                    array_push($filtered['blocking'], $relationships[$i]);
                }

                if($relationships[$i]['Relationship']['person1_to_person2_block'] == 1){
                    array_push($filtered['blocked'], $relationships[$i]);
                }

                if($relationships[$i]['Relationship']['friends'] == 1){
                    array_push($filtered['friends'], $relationships[$i]);
                }
            }

            if($relationships[$i]['Relationship']['friend_request'] == $personId){
                array_push($filtered['response_pending'], $relationships[$i]);
            }

            if($relationships[$i]['Relationship']['friend_request'] != $personId
                    && $relationships[$i]['Relationship']['friend_request'] != null){
                array_push($filtered['request_pending'], $relationships[$i]);
            }

            unset($relationships[$i]);
        }

        return $filtered;
    }
}