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
            ),
            'contain' => array()
        ));

        return $relationships;
    }

    public function fetchProccessedRelationships($personId)
    {
        $relationships = $this->find('all', array(
            'conditions' => array(
                'OR' => array(
                    'Relationship.person1_id' => $personId,
                    'Relationship.person2_id' => $personId
                )
            )
        ));

        return $this->processRelationships($personId, $relationships);
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
            ),
            'contain' => array()
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

    public function processRelationships($personId, $relationships)
    {
        $processedRelationships = array();

        foreach($relationships as $relationship){

            if($relationship['Relationship']['person1_id'] == $personId){

                $id = $relationship['Relationship']['person2_id'];
                $processedRelationships[$id] = array();

                if(isset($relationship['Person2'])){
                    $processedRelationships[$id] = $relationship['Person2'];
                }else{
                    $processedRelationships[$id]['id'] = $id;
                }

                if($relationship['Relationship']['person1_to_person2_follow'] == 1){
                    $processedRelationships[$id]['status']['following'] = 1;
                    $processedRelationships[$id]['actions']['unfollow'] = '/relationships/unfollow/'.$id;
                }

                if($relationship['Relationship']['person2_to_person1_follow'] == 1){
                    $processedRelationships[$id]['status']['follower'] = 1;
                }

                if($relationship['Relationship']['person1_to_person2_block'] == 1){
                    $processedRelationships[$id]['status']['blocking'] = 1;
                    $processedRelationships[$id]['actions']['unblock'] = '/relationships/unblock/'.$id;
                }else{
                    $processedRelationships[$id]['actions']['block'] = '/relationships/block/'.$id;
                }

                if($relationship['Relationship']['person2_to_person1_block'] == 1){
                    $processedRelationships[$id]['status']['blocked'] = 1;
                }

                if($relationship['Relationship']['friend_request'] != null){
                    if($relationship['Relationship']['friend_request'] == $personId){
                        $processedRelationships[$id]['status']['response_pending'] = 1;
                    }else{
                        $processedRelationships[$id]['status']['request_pending'] = 1;
                        $processedRelationships[$id]['actions']['deny_friend_request'] =
                                                                            '/relationships/deny_friend_request/'.$id;

                        $processedRelationships[$id]['actions']['accept_friend_request'] =
                                                                            '/relationships/accept_friend_request/'.$id;
                    }
                }else{
                    if($relationship['Relationship']['friends'] == 1){
                        $processedRelationships[$id]['status']['friends'] = 1;
                        $processedRelationships[$id]['actions']['unfriend'] = '/relationships/unfriend/'.$id;
                    }else{
                        $processedRelationships[$id]['actions']['send_friend_request'] =
                                                                            '/relationships/send_friend_request/'.$id;
                    }
                }

            }

            if($relationship['Relationship']['person2_id'] == $personId){

                $id = $relationship['Relationship']['person1_id'];
                $processedRelationships[$id] = array();

                if(isset($relationship['Person1'])){
                    $processedRelationships[$id] = $relationship['Person1'];
                }else{
                    $processedRelationships[$id]['id'] = $id;
                }

                if($relationship['Relationship']['person2_to_person1_follow'] == 1){
                    $processedRelationships[$id]['status']['following'] = 1;
                    $processedRelationships[$id]['actions']['unfollow'] = '/relationships/unfollow/'.$id;
                }

                if($relationship['Relationship']['person1_to_person2_follow'] == 1){
                    $processedRelationships[$id]['status']['follower'] = 1;
                }

                if($relationship['Relationship']['person2_to_person1_block'] == 1){
                    $processedRelationships[$id]['status']['blocking'] = 1;
                    $processedRelationships[$id]['actions']['unblock'] = '/relationships/unblock/'.$id;
                }else{
                    $processedRelationships[$id]['actions']['block'] = '/relationships/block/'.$id;
                }

                if($relationship['Relationship']['person1_to_person2_block'] == 1){
                    $processedRelationships[$id]['status']['blocked'] = 1;
                }

                if($relationship['Relationship']['friend_request'] != null){
                    if($relationship['Relationship']['friend_request'] == $personId){
                        $processedRelationships[$id]['status']['response_pending'] = 1;
                    }else{
                        $processedRelationships[$id]['status']['request_pending'] = 1;
                        $processedRelationships[$id]['actions']['accept_friend_request'] =
                                                                            '/relationships/accept_friend_request/'.$id;

                        $processedRelationships[$id]['actions']['deny_friend_request'] =
                                                                            '/relationships/deny_friend_request/'.$id;
                    }
                }else{
                    if($relationship['Relationship']['friends'] == 1){
                        $processedRelationships[$id]['status']['friends'] = 1;
                        $processedRelationships[$id]['actions']['unfriend'] = '/relationships/unfriend/'.$id;
                    }else{
                        $processedRelationships[$id]['actions']['send_friend_request'] =
                                                                            '/relationships/send_friend_request/'.$id;
                    }
                }
            }
        }

        return $processedRelationships;

    }
}