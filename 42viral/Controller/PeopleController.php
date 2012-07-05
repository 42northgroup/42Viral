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
 * @package       42viral\Person
 */

App::uses('AppController', 'Controller');
App::uses('Scrub', 'Lib');
/**
 * Manages people in the system
 * @subpackage app.core
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Lyubomir R Dimov <lrdimov@yahoo.com>
 * @package 42viral\Person
 */
 class PeopleController extends AppController
{

    /**
     * Models used in this controller
     * @var array
     * @access public
     */
    public $uses = array('CaseModel', 'Invite', 'Notification', 'Person');


    /**
     * beforeFilter
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();
    }

    /**
     * Retrives all users in the system
     *
     * @access public
     *
     */
    public function admin_index()
    {
        $people = $this->Person->find('all');
        $this->set('people', $people);
        $this->set('title_for_layout', 'People (CRM)');
    }

    /**
     * Retrieves a person's details
     *
     * @access public
     * @param string $username unique identifier
     *
     */
    public function admin_view($username){
        $person = $this->Person->find('first', array(
			'conditions' => array('or' => array(
                'Person.id' => $username,
                'Person.username' => $username,
                'Person.email' => $username
            )),
            'contain'=>array()
        ));

        $this->set('person', $person);
        $this->set('userProfile', $person);
        $this->set('title_for_layout',
            $person['Person']['name']==''?$person['Person']['username']:$person['Person']['name']);
    }

    /**
    * Sends an ivite to all emais passed through the form
    *
    * @access public
    * @return void
    */
    public function invite()
    {
       if(!empty ($this->data)){
           $emails = explode(',', $this->data['Invite']['emails']);

           $validated_emails = array();
           $bad_emails = array();

           for($i=0; $i<count($emails); $i++){
               $emails[$i] = trim($emails[$i]);
               if(Validation::email($emails[$i])){
                   array_push($validated_emails, trim($emails[$i]));
               }else{
                   array_push($bad_emails, trim($emails[$i]));
               }

           }

           foreach($validated_emails as $email){

               if($this->Invite->add()){

                   $invitation_token = $this->Invite->id;
                   $invitee = $this->Session->read('Auth.User.name');

                   /*
                   $additionalObjects = array(
                       'invitation_token' => $invitation_token,
                       'invitee' => $invitee,
                       'invite_body' => Scrub::htmlStrict($this->data['Invite']['message'])
                   );
                   */
                   $this->Notification->notify('invitation_to_join',
                       array(
                           'type'=>'email',
                           'email'=>array(
                                'to'=>$email
                           ),
                           'message'=>array(
                               'invitee'=>$invitee,
                               'token' => $invitation_token,
                               //'msg'=>Scrub::htmlStrict($this->data['Invite']['message'])
                           ),
                           'additional'=>array()
                       )
                   );

               }
           }

           if(!empty ($bad_emails)){
               $flash_string = 'An invitaion could not be sent to the following email addresses:';
               $this->request->data['Invite']['emails'] = '';

               foreach ($bad_emails as $email){
                   $flash_string .= '<br/>'.$email;
                   $this->request->data['Invite']['emails'] .= $email.',';
               }

               $this->request->data['Invite']['emails'] = substr($this->request->data['Invite']['emails'], 0, -1);

               $flash_string .= '<br/>Please check to make to sure the of theses addresses is correct.';
               $this->Session->setFlash(_($flash_string), 'error');
           }else{
               $this->Session->setFlash(_('Invitations have been sent'), 'success');
           }
       }

       $this->set('title_for_layout', "Invite Your Friends");
    }
}