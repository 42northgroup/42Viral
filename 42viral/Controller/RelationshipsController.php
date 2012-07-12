<?php
/**
 * Manages people in the system
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
 * @package       42viral\Relationships
 */

App::uses('AppController', 'Controller');
/**
 * Manages relationships in the system
 * @author Lyubomir R Dimov <lubo.dimov@42northgroup.com>
 * @package 42viral\Relationships
 */
 class RelationshipsController extends AppController
{

    /**
     * Models used in this controller
     * @var array
     * @access public
     */
    public $uses = array('Relationship', 'Person');


    /**
     * beforeFilter
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();
    }

    public function index()
    {
        $display = 'none';
        $personId = $this->Session->read('Auth.User.id');
        $this->set('userId', $personId);

        if(!empty($this->data)){
            $this->redirect('/relationships/index/keywords:'.$this->data['Person']['keywords']);
        }elseif(!empty($this->params['named'])){
            $conditions = array('OR'=>array());
            $this->request->data['Person']['keywords'] = $this->params['named']['keywords'];
            $keywords = explode(' ', $this->params['named']['keywords']);

            foreach($keywords as $keyword){
                array_push($conditions['OR'], "Person.email LIKE '%{$keyword}%'");
                array_push($conditions['OR'], "Person.username LIKE '%{$keyword}%'");
                array_push($conditions['OR'], "Person.first_name LIKE '%{$keyword}%'");
                array_push($conditions['OR'], "Person.last_name LIKE '%{$keyword}%'");
            }

            $this->paginate = array(
                'conditions' => $conditions,
                'limit' => 20,
                'contain'=>array()
            );

            $data = $this->paginate('Person');

            if(!empty($data)){
                $peopleIds = Set::extract('/Person/id', $data);
                $relationships = $this->Relationship->fetchPersonRelationshipsList($personId, $peopleIds);
                $this->set('relationships', $relationships);
            }

            $display = 'results';

            $this->set(compact('data'));
        }

        $this->set('title_for_layout', 'Relationships');
        $this->set('display', $display);
    }

    public function follow($personToBeFollowed)
    {

        $personToFollow = $this->Session->read('Auth.User.id');

        $people = array($personToBeFollowed, $personToFollow);

        $relationship = $this->Relationship->find('first', array(
            'conditions' => array(
                'Relationship.person1_id' => $people,
                'Relationship.person2_id' => $people
            )
        ));

        if(!empty($relationship)){
            if($relationship['Relationship']['person1_id'] == $personToFollow){
                if($relationship['Relationship']['person2_to_person1_block'] != 1){
                    $relationship['Relationship']['person1_to_person2_follow'] = 1;
                }else{
                    $this->Session->setFlash(_('You can not follow this person because they have blocked you'),'error');
                    $this->redirect($this->referer());
                }

            }else{
                if($relationship['Relationship']['person1_to_person2_block'] != 1){
                    $relationship['Relationship']['person2_to_person1_follow'] = 1;
                }else{
                    $this->Session->setFlash(_('You can not follow this person because they have blocked you'),'error');
                    $this->redirect($this->referer());
                }
            }
        }else{
            $relationship['Relationship']['person1_id'] = $personToFollow;
            $relationship['Relationship']['person2_id'] = $personToBeFollowed;
            $relationship['Relationship']['person1_to_person2_follow'] = 1;
        }

        if($this->Relationship->save($relationship)){
            $this->Session->setFlash(_('You are now following this person'), 'success');
        }else{
            $this->Session->setFlash(_('You could not follow this person'), 'error');
        }

        $this->redirect($this->referer());
    }

    public function unfollow($personToBeUnfollowed)
    {

        $personToUnfollow = $this->Session->read('Auth.User.id');

        $people = array($personToBeUnfollowed, $personToUnfollow);

        $relationship = $this->Relationship->find('first', array(
            'conditions' => array(
                'Relationship.person1_id' => $people,
                'Relationship.person2_id' => $people
            )
        ));

        if(!empty($relationship)){
            if($relationship['Relationship']['person1_id'] == $personToUnfollow){
                $relationship['Relationship']['person1_to_person2_follow'] = 0;
            }else{
                $relationship['Relationship']['person2_to_person1_follow'] = 0;
            }

            if($this->Relationship->save($relationship)){
                $this->Session->setFlash(_('You are not following this person anymore'), 'success');
            }else{
                $this->Session->setFlash(_('You could not unfollow this person'), 'error');
            }
        }else{
            $this->Session->setFlash(_('You are not following this person'), 'error');
        }

        $this->redirect($this->referer());
    }

    public function unblock($personToBeUnblocked)
    {

        $personToUnblock = $this->Session->read('Auth.User.id');

        $people = array($personToBeUnblocked, $personToUnblock);

        $relationship = $this->Relationship->find('first', array(
            'conditions' => array(
                'Relationship.person1_id' => $people,
                'Relationship.person2_id' => $people
            )
        ));

        if(!empty($relationship)){
            if($relationship['Relationship']['person1_id'] == $personToUnblock){
                $relationship['Relationship']['person1_to_person2_block'] = 0;
            }else{
                $relationship['Relationship']['person2_to_person1_block'] = 0;
            }

            if($this->Relationship->save($relationship)){
                $this->Session->setFlash(_('You have unblocked this person anymore'), 'success');
            }else{
                $this->Session->setFlash(_('You could unblocked unfollow this person'), 'error');
            }
        }else{
            $this->Session->setFlash(_('You have not blocked this person'), 'error');
        }

        $this->redirect($this->referer());
    }

    public function block($personToBeBlocked)
    {

        $personToBlock = $this->Session->read('Auth.User.id');

        $people = array($personToBeBlocked, $personToBlock);

        $relationship = $this->Relationship->find('first', array(
            'conditions' => array(
                'Relationship.person1_id' => $people,
                'Relationship.person2_id' => $people
            )
        ));

        if(!empty($relationship)){
            if($relationship['Relationship']['person1_id'] == $personToBlock){
                $relationship['Relationship']['person1_to_person2_block'] = 1;
            }else{
                $relationship['Relationship']['person2_to_person1_block'] = 1;
            }
        }else{
            $relationship['Relationship']['person1_id'] = $personToBlock;
            $relationship['Relationship']['person2_id'] = $personToBeBlocked;
            $relationship['Relationship']['person1_to_person2_block'] = 1;
        }

        $relationship['Relationship']['friends'] = 0;
        $relationship['Relationship']['person2_to_person1_follow'] = 0;
        $relationship['Relationship']['person1_to_person2_follow'] = 0;

        if($this->Relationship->save($relationship)){
            $this->Session->setFlash(_('You are have blocked this person'), 'success');
        }else{
            $this->Session->setFlash(_('You could not block this person'), 'error');
        }

        $this->redirect($this->referer());
    }

    public function send_friend_request($personId)
    {

        $requester = $this->Session->read('Auth.User.id');

        $people = array($requester, $personId);

        $relationship = $this->Relationship->find('first', array(
            'conditions' => array(
                'Relationship.person1_id' => $people,
                'Relationship.person2_id' => $people
            )
        ));

        if(!empty($relationship)){
            if($relationship['Relationship']['friends'] == 1){
                $this->Session->setFlash(_('You are already friends with this person'), 'success');

            }elseif($relationship['Relationship']['friend_request'] != null){
                $this->Session->setFlash(_('There already is a friend request pending between you and this person'),
                                                                                                            'success');
            }else{
                $relationship['Relationship']['friend_request'] = $requester;

                if($relationship['Relationship']['person1_id'] == $requester){
                    $relationship['Relationship']['person1_to_person2_block'] = 0;
                }else{
                    $relationship['Relationship']['person2_to_person1_block'] = 0;
                }
            }
        }else{
            $relationship['Relationship']['person1_id'] = $requester;
            $relationship['Relationship']['person2_id'] = $personId;
            $relationship['Relationship']['friend_request'] = $requester;
        }

        if($this->Relationship->save($relationship)){
            $this->Session->setFlash(_('Your friend request has been sent'), 'success');
        }else{
            $this->Session->setFlash(_('Your friend request could not be sent'), 'error');
        }

        $this->redirect($this->referer());
    }

    public function accept_friend_request($personId)
    {

        $accepter = $this->Session->read('Auth.User.id');

        $people = array($accepter, $personId);

        $relationship = $this->Relationship->find('first', array(
            'conditions' => array(
                'Relationship.person1_id' => $people,
                'Relationship.person2_id' => $people
            )
        ));

        if(!empty($relationship)){
            if($relationship['Relationship']['friends'] == 1){
                $this->Session->setFlash(_('You are already friends with this person'), 'success');

            }elseif($relationship['Relationship']['friend_request'] == null){
                $this->Session->setFlash(_('This person has not sent a friend request for you to accept'), 'error');

            }else{

                if($relationship['Relationship']['person1_id'] == $accepter){
                    $relationship['Relationship']['person1_to_person2_block'] = 0;
                }else{
                    $relationship['Relationship']['person2_to_person1_block'] = 0;
                }

                $relationship['Relationship']['friend_request'] = null;
                $relationship['Relationship']['friends'] = 1;

                if($this->Relationship->save($relationship)){
                    $this->Session->setFlash(_('You are now friends with this person'), 'success');
                }else{
                    $this->Session->setFlash(_('You were not able to accept the friend request'), 'success');
                }
            }
        }else{
            $this->Session->setFlash(_('This person has not sent a friend request for you to accept'), 'error');
        }

        $this->redirect($this->referer());
    }

    public function deny_friend_request($personId)
    {

        $denier = $this->Session->read('Auth.User.id');

        $people = array($denier, $personId);

        $relationship = $this->Relationship->find('first', array(
            'conditions' => array(
                'Relationship.person1_id' => $people,
                'Relationship.person2_id' => $people
            )
        ));

        if(!empty($relationship)){
            if($relationship['Relationship']['friend_request'] != null){

                $relationship['Relationship']['friend_request'] = null;
                if($this->Relationship->save($relationship)){
                    $this->Session->setFlash(_('You have denied the friend request'), 'success');
                }else{
                    $this->Session->setFlash(_('Friend request could not be denied'), 'success');
                }
            }else{
                $this->Session->setFlash(_('There is no friend request pending between you and this person'), 'error');
            }
        }else{
            $this->Session->setFlash(_('There is no friend request pending between you and this person'), 'error');
        }

        $this->redirect($this->referer());
    }

    public function unfriend($personId)
    {

        $unfriender = $this->Session->read('Auth.User.id');

        $people = array($unfriender, $personId);

        $relationship = $this->Relationship->find('first', array(
            'conditions' => array(
                'Relationship.person1_id' => $people,
                'Relationship.person2_id' => $people
            )
        ));

        if(!empty($relationship)){
            if($relationship['Relationship']['friends'] == 1){
                $relationship['Relationship']['friends'] = 0;
                $relationship['Relationship']['friend_request'] = null;

                if($this->Relationship->save($relationship)){
                    $this->Session->setFlash(_('You are not friends with this person anymore'), 'success');
                }else{
                    $this->Session->setFlash(_('You were not able to unfriend this person'), 'error');
                }
            }
        }else{
            $this->Session->setFlash(_('You are not friends with this person'), 'error');
        }

        $this->redirect($this->referer());
    }

    public function my_relationships()
    {
        $personId = $this->Session->read('Auth.User.id');
        $myRealtionships = $this->Relationship->fetchProccessedRelationships($personId);

        $this->set('myRealtionships', $myRealtionships);
        $this->set('title_for_layout', 'My Relationships');
    }
}
