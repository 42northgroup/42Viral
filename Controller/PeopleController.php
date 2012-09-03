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
    public $uses = array(
        'Invite',
        'Notification',
        'Person',
        'SocialNetwork'
    );


    /**
     * beforeFilter
     * @access public
     */
    public function beforeFilter(){
        parent::beforeFilter();
        $this->auth(array('index', 'view'));
    }

    /**
     * Provides an index of all system persons
     *
     *
     * @access public
     * @todo TestCase
     */
    public function index()
    {
        $people = $this->Person->find(
            'all',
            array(
                'conditions'=>array(
                    'Person.access' => array('public')
                )
            )
        );
        $this->set('people', $people);
        $this->set('title_for_layout', 'People');
    }

    /**
     * Action to provide a form for editing person data and pre-loading the form with previously saved data
     *
     * @access public
     * @param string $personId provides a unique ID base on which we can find the user's person
     *
     */
    public function edit($personId) {

        $this->_validRecord('Person', $personId);
        $this->_mine($personId, 'Auth.User.Person.id');

        if(!empty($this->data)){
            if($this->Person->saveAll($this->data)){
                $this->Session->setFlash(__('Your person has been updated'), 'success');
            }else{
                $this->Session->setFlash(__('Your person has been updated'), 'serror');
            }
        }

        $this->data = $this->Person->find(
            'first',
            array(
                'conditions' => array(
                    'Person.id' => $personId
                ),
                    'contain' =>    array(
                    'Person' => array()
                )
            )
        );

        /* Restructure the Person data to fit the the userPerson hook */
        $userPerson = array();
        $userPerson['Person'] = $this->data['Person'];
        $userPerson['Person']['Person'] = $this->data['Person'];

        $this->set('userPerson', $userPerson);
        $this->set('title_for_layout', 'Edit Person');
    }

    /**
     * Retrives and displays a user's person
     *
     * @access public
     * @param string $token the unique identifier which we use to retrieve a user person
     */
    public function view($token = null)
    {
        // If we have no token, we will use the logged in user.
        if(is_null($token)) {
            $token = $this->Session->read('Auth.User.username');
        }

        $this->_validRecord('Person', $token, 'username');

        //Get the user data
        /*
        $user = $this->User->find(
            'first',
            array(
                'conditions'=>array(
                    'or' => array(
                        'User.id' => $token,
                        'User.username' => $token,
                        'User.email' => $token
                    )
                ),
                'contain' =>    array(
                    'Address'=>array(),
                    'EmailAddress'=>array(
                        'conditions'=>array(
                            'EmailAddress.access'=>'public'
                        )
                    ),
                    'PhoneNumber'=>array(
                        'conditions'=>array(
                            'PhoneNumber.access'=>'public'
                        )
                    ),
                    'SocialNetwork'=>array(),
                    'UserSetting'=>array()
                )
            )
        );
*/
        // Mine
        if($this->Session->read('Auth.User.username') == $token){
            $this->set('mine', true);
        }else{
            $this->set('mine', false);
        }

        $person = $this->Person->find(
            'first',
            array(
                'conditions'=>array(
                    'Person.username'=>$token
                ),
                'fields'=>array(
                    'Person.id',
                    'Person.name',
                    'Person.bio',
                    'Person.username',
                    'Person.url',
                    'Person.email'
                ),
                'contain'=>array(
                    'Address'=>array(
                        'fields'=>array(
                            'Address.label',
                            'Address.line1',
                            'Address.line2',
                            'Address.city',
                            'Address.state',
                            'Address.zip',
                            'Address.country'
                        ),
                        'conditions'=>array(
                            'Address.access'=>'public'
                        )
                    ),
                    'EmailAddress'=>array(
                        'fields'=>array(
                            'EmailAddress.label',
                            'EmailAddress.email_address'
                        ),
                        'conditions'=>array(
                            'EmailAddress.access'=>'public'
                        )
                    ),
                    'PhoneNumber'=>array(
                        'fields'=>array(
                            'PhoneNumber.label',
                            'PhoneNumber.phone_number'
                        ),
                        'conditions'=>array(
                            'PhoneNumber.access'=>'public'
                        )
                    ),
                    'SocialNetwork'=>array(
                        'fields'=>array(
                            'SocialNetwork.network',
                            'SocialNetwork.profile_url'
                        )
                    )
                )
            )
        );

        $this->set('person', $person);
        $this->set('networks', $this->SocialNetwork->getSocialNetworks());
        $this->set('personId', $person['Person']['id']);
        $this->set('title_for_layout', ProfileUtility::name($person['Person']) . "'s Person");

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