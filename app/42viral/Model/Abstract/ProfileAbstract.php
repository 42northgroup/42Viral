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
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
abstract class ProfileAbstract extends AppModel
{
    public $name = 'Profile';

   /**
    * Fetch a given user's profile data
    *
    * @author Zubin Khavarian <zubin.khavarian@42viral.com>
    * @access public
    * @param string $userId
    * @return Profile
    */
   public function fetchUserProfile($userId)
   {
       $userProfile = $this->find('first', array(
           'contain' => array(),

           'conditions' => array(
               'Profile.owner_user_id' => $userId
           )
       ));

       return $userProfile;
   }


   /**
    * Calculate user profile progress based on what fields have been compelted
    *
    * @author Zubin Khavarian <zubin.khavarian@42viral.com>
    * @access public
    * @param string $userId
    * @return integer
    */
   public function userProfileProgress($userId)
   {
       $userProfile = $this->find('first', array(
           'contain' => array(),

           'conditions' => array(
               'Profile.owner_user_id' => $userId
           )
       ));

       $progress = 0;

       if(empty($userProfile)) {
           $progress = 0;
       } else {
           if(
               !empty($userProfile['Profile']['first_name']) ||
               !empty($userProfile['Profile']['last_name'])
           ) {
               $progress += 20;
           }

           if(!empty($userProfile['Profile']['bio'])) {
               $progress += 80;
           }
       }

       return $progress;
   }
}