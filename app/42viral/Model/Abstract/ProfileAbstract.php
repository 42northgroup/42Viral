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
 * Mangages the person profile objects
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.org>
 * @author Jason D Snider <jason.snider@42viral.org>
 */
class ProfileAbstract extends AppModel
{
    public $name = 'Profile';
    
    public $useTable = 'profiles';


    /**
     *
     * @var array
     * @access public
     */
    public $belongsTo = array(
        'Person' => array(
            'className' => 'Person',
            'foreignKey' => 'owner_person_id',
            'dependent' => true
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'owner_person_id',
            'dependent' => true
        ),        
    );

    /**
     *
     * @var array
     */
    public $actsAs = array(
        'Scrub' => array(
            'Filters' => array(
                'trim' => '*',
                'htmlStrict' => array('bio'),
                'noHtml'=>array('tease')
            )
        )
    );

   /**
    * Fetch a given user's profile data
    *
    * @access public
    * @param string $userId
    * @return Profile
    */
   public function fetchUserProfile($userId)
   {
       $userProfile = $this->find('first', array(
           'contain' => array(),

           'conditions' => array(
               'Profile.owner_person_id' => $userId
           )
       ));

       return $userProfile;
   }
   
      
    /**
     * Returns a person's profile data with the specified associated data. 
     * NOTE: When using the by clause please understand, this MUST be a unique index in the profiles table
     * 
     * @param string $id - An id for retreving records
     * @param string|array $with
     * @param string $by - This will usally be id, but sometimes we want to use something else
     * @return array
     * @access public
     */
    public function fetchProfileWith($id, $with = array(), $by = 'id')
    {

        //Allows predefined data associations in the form of containable arrays
        if(!is_array($with)){
            
            switch(strtolower($with)){
                case 'person':
                    $with = array('Person');
                break;   
            
                default:
                    $with = array();
                break;
            }
  
        }
        
        //Go fetch the profile
        $userProfile = $this->find('first', array(
           'contain' => $with,

           'conditions' => array(
               "Profile.{$by}"  => $id
           )
        ));

        return $userProfile;
    }


   /**
    * Calculate user profile progress based on what fields have been compelted
    *
    * @access public
    * @param string $userId
    * @return integer
    */
   public function userProfileProgress($userId)
   {
       $userProfile = $this->fetchProfileWith($userId, 'person', 'owner_person_id');

       $progress = 0;

       if(empty($userProfile)) {
           $progress = 0;
       } else {
           if(
               !empty($userProfile['Person']['first_name']) ||
               !empty($userProfile['Person']['last_name'])
           ) {
               $progress += 20;
           }

           if(!empty($userProfile['Profile']['tease'])) {
               $progress += 80;
           }
       }

       return $progress;
   }
}