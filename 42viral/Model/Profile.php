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
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 */
class Profile extends AppModel
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
        )  
    );

    /**
     *
     * @var array
     */
    public $actsAs = array(
        'ContentFilters.Scrubable' => array(
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
   
   /**
    * Uses the information from the user profile to build an xCard
    * 
    * @access public
    * @param array $profile
    * @return string 
    */
   public function fetchXcard($profile)
    {              
        $label = (isset($profile['address1'])?$profile['address1'].' ':'').
               (isset($profile['address2'])?$profile['address2'].' ':' ').
               (isset($profile['city'])?$profile['city'].', ':', ').
               (isset($profile['state'])?$profile['state'].' ':' ').
               (isset($profile['zip'])?$profile['zip'].' ':' ').
               (isset($profile['country'])?$profile['country'].'':'');
        
        $xcard =    '<?xml version="1.0" encoding="UTF-8"?>'.
                    '<vcards xmlns="urn:ietf:params:xml:ns:vcard-4.0">'.
                      '<vcard>'.
                        '<n>'.
                          '<surname>'.$profile['last_name'].'</surname>'.
                          '<given>'.$profile['first_name'].'</given>'.
                          '<additional/>'.
                          '<prefix/>'.
                          '<suffix/>'.
                        '</n>'.
                        '<fn>'.
                            '<text>'.
                                $profile['first_name'].' '.$profile['last_name'].
                            '</text>'.
                        '</fn>'.
                        //'<org><text>Bubba Gump Shrimp Co.</text></org>'.
                        //'<title><text>Shrimp Man</text></title>'.
                        '<photo>'.
                            '<uri>'.
                                (isset($profile['image_read_path'])?
                                   'http://loc.build.42viral.org'.$profile['image_read_path'].'/avatar/profile.jpg':'').
                            '</uri>'.
                        '</photo>'.
                        '<tel>'.
                          '<parameters>'.
                            '<type>work</type>'.
                            '<type>voice</type>'.
                          '</parameters>'.
                          '<uri>'.
                            (isset($profile['work_phone'])?$profile['work_phone']:'').
                          '</uri>'.
                        '</tel>'.
                        '<tel>'.
                          '<parameters>'.
                            '<type>home</type>'.
                            '<type>voice</type>'.
                          '</parameters>'.
                          '<uri>'
                            .(isset($profile['home_phone'])?$profile['home_phone']:'')
                          .'</uri>'.
                        '</tel>'.
                        '<adr>'.
                          '<parameters>'.
                            '<type>home</type>'.
                            '<label>'.
                              $label.
                            '</label>'.
                          '</parameters>'.
                          '<pobox/>'.
                          '<ext/>'.
                          '<street>'
                            .$profile['address1'].' '.$profile['address2'].
                          '</street>'.
                          '<locality>'.
                            $profile['city'].
                          '</locality>'.
                          '<region>'.
                            $profile['state'].
                          '</region>'.
                          '<code>'.
                            $profile['zip'].
                          '</code>'.
                          '<country>'.
                            $profile['country'].
                          '</country>'.
                        '</adr>'.
                        '<email>'.
                            '<text>'.$profile['email'].'</text>'.
                        '</email>'.
                        '<rev>'.
                            '<timestamp>'
                                .date('Ymd', strtotime($profile['modified'])).'T'
                                                                .date('His', strtotime($profile['modified'])).'Z'.
                            '</timestamp>'.
                        '</rev>'.
                      '</vcard>'.
                    '</vcards>';
        
        return $xcard;
    }
    
    /**
     * Uses the information from the user profile to build a vCard
     * 
     * @access public
     * @param array $profile
     * @param int $version
     * @return string 
     */
    public function fetchVcard($profile, $version)
    {
        $adr = (isset($profile['address1'])?$profile['address1'].' ':'').
               (isset($profile['address2'])?$profile['address2'].';':';').
               (isset($profile['city'])?$profile['city'].';':';').
               (isset($profile['state'])?$profile['state'].';':';').
               (isset($profile['zip'])?$profile['zip'].';':';').
               (isset($profile['country'])?$profile['country'].';':';');
       
        $label = (isset($profile['address1'])?$profile['address1'].' ':'').
               (isset($profile['address2'])?$profile['address2'].'\n':'\n').
               (isset($profile['city'])?$profile['city'].', ':', ').
               (isset($profile['state'])?$profile['state'].' ':' ').
               (isset($profile['zip'])?$profile['zip'].'\n':'\n').
               (isset($profile['country'])?$profile['country'].'':'');
        
        $label_v2 = (isset($profile['address1'])?$profile['address1'].' ':'').
               (isset($profile['address2'])?$profile['address2'].'=0D=0A':'=0D=0A').
               (isset($profile['city'])?$profile['city'].', ':', ').
               (isset($profile['state'])?$profile['state'].' ':' ').
               (isset($profile['zip'])?$profile['zip'].'=0D=0A':'=0D=0A').
               (isset($profile['country'])?$profile['country'].'':'');
        
       $map = array(
           4 => array(
               'VERSION' => '4.0',
               'N' => (isset($profile['last_name'])?$profile['last_name']:'').';'
                      .(isset($profile['first_name'])?$profile['first_name']:'').';;;',
               'FN' => (isset($profile['first_name'])?$profile['first_name'].' ':'')
                       .(isset($profile['last_name'])?$profile['last_name']:''),
               'NICKNAME' => isset($profile['username'])?$profile['username']:'',
               'PHOTO' => isset($profile['image_read_path'])?$profile['image_read_path'].'/avatar/profile.jpg':'',
               //'BDAY' => 'Birthday',
               'TEL' => isset($profile['home_phone'])?'TYPE="work,voice";VALUE=uri:tel:'.$profile['home_phone']:'',
               'ADR' => $adr!=''?'TYPE=home;LABEL="'.$label.'":;;'.$adr:'',
               //'LABEL' => 'Label Address',
               'EMAIL' => isset($profile['email'])?$profile['email']:'',
               //'MAILER' => 'Email Program',
               //'TZ' => 'Time Zone',
               //'GEO' => 'Global Positioning',
               //'TITLE' => 'Title',
               //'ROLE' => 'Role or occupation',
               //'LOGO' => 'Logo',
               //'AGENT' => 'Agent',
               //'ORG' => 'Organization Name',
               //'NOTE' => 'Note',
               'REV' => isset($profile['modified'])?date('Ymd', strtotime($profile['modified'])).'T'
                                                    .date('His', strtotime($profile['modified'])).'Z':'',
               //'SOUND' => 'Sound',
               'URL' => isset($profile['username'])?'http://loc.build.42viral.org/p/'.$profile['username']:'',
               'UID' => isset($profile['id'])?$profile['id']:'',
               'KEY' => ''
           ),
           
           3 => array(
               'VERSION' => '3.0',
               'N' => (isset($profile['last_name'])?$profile['last_name']:'').';'
                      .(isset($profile['first_name'])?$profile['first_name']:''),
               'FN' => (isset($profile['first_name'])?$profile['first_name'].' ':'')
                       .(isset($profile['last_name'])?$profile['last_name']:''),
               'NICKNAME' => isset($profile['username'])?$profile['username']:'',
               'PHOTO' => isset($profile['image_read_path'])?
                 'VALUE=URL;TYPE=JPG:http://loc.build.42viral.org'.$profile['image_read_path'].'/avatar/profile.jpg':'',
               //'BDAY' => 'Birthday',
               'TEL' => isset($profile['home_phone'])?'TYPE=WORK,VOICE:'.$profile['home_phone']:'',
               'ADR' => $adr!=''?'TYPE=HOME:;;'.$adr:'',
               'LABEL' => $label!=''?'TYPE=HOME:'.$label:'',
               'EMAIL' => isset($profile['email'])?'TYPE=PREF,INTERNET:'.$profile['email']:'',
               //'MAILER' => 'Email Program',
               //'TZ' => 'Time Zone',
               //'GEO' => 'Global Positioning',
               //'TITLE' => 'Title',
               //'ROLE' => 'Role or occupation',
               //'LOGO' => 'Logo',
               //'AGENT' => 'Agent',
               //'ORG' => 'Organization Name',
               //'NOTE' => 'Note',
               'REV' => isset($profile['modified'])?date('Y-m-d', strtotime($profile['modified'])).'T'
                                                    .date('H:i:s', strtotime($profile['modified'])).'Z':'',
               //'SOUND' => 'Sound',
               'URL' => isset($profile['username'])?'http://loc.build.42viral.org/p/'.$profile['username']:'',
               'UID' => isset($profile['id'])?$profile['id']:'',
               'KEY' => ''
           ),
           
           2 => array(
               'VERSION' => '2.1',
               'N' => (isset($profile['last_name'])?$profile['last_name']:'').';'
                      .(isset($profile['first_name'])?$profile['first_name']:''),
               'FN' => (isset($profile['first_name'])?$profile['first_name'].' ':'')
                       .(isset($profile['last_name'])?$profile['last_name']:''),
               'NICKNAME' => isset($profile['username'])?$profile['username']:'',
               'PHOTO' => isset($profile['image_read_path'])?
                       'URL;TYPE=JPG:http://loc.build.42viral.org'.$profile['image_read_path'].'/avatar/profile.jpg':'',
               //'BDAY' => 'Birthday',
               'TEL' => isset($profile['home_phone'])?'WORK;VOICE:'.$profile['home_phone']:'',
               'ADR' => $adr!=''?'HOME:;;'.$adr:'',
               'LABEL' => $label!=''?'HOME;ENCODING=QUOTED-PRINTABLE:'.$label_v2:'',
               'EMAIL' => isset($profile['email'])?'PREF;INTERNET:'.$profile['email']:'',
               //'MAILER' => 'Email Program',
               //'TZ' => 'Time Zone',
               //'GEO' => 'Global Positioning',
               //'TITLE' => 'Title',
               //'ROLE' => 'Role or occupation',
               //'LOGO' => 'Logo',
               //'AGENT' => 'Agent',
               //'ORG' => 'Organization Name',
               //'NOTE' => 'Note',
               'REV' => isset($profile['modified'])?date('Ymd', strtotime($profile['modified'])).'T'
                                                    .date('His', strtotime($profile['modified'])).'Z':'',
               //'SOUND' => 'Sound',
               'URL' => isset($profile['username'])?'loc.build.42viral.org/p/'.$profile['username']:'',
               'UID' => isset($profile['id'])?$profile['id']:'',
               'KEY' => ''
           )
       );
       
       $vcard = "BEGIN:VCARD\n";
       foreach ($map[$version] as $key => $val){
           if($version == 4){
               if($val != ''){
                   if(!in_array($key, array('ADR', 'TEL'))){
                       $vcard .= "$key:$val\n";
                   }else{
                       $vcard .= "$key;$val\n";
                   }
               }
           }elseif($version == 3){
               if(!in_array($key, array('ADR', 'TEL', 'EMAIL', 'LABEL', 'PHOTO'))){
                   $vcard .= "$key:$val\n";
               }else{
                   $vcard .= "$key;$val\n";
               }
           }elseif($version == 2){
               if(!in_array($key, array('ADR', 'TEL', 'EMAIL', 'LABEL', 'PHOTO'))){
                   $vcard .= "$key:$val\n";
               }else{
                   $vcard .= "$key;$val\n";
               }
           }
       }
       
       $vcard .= "END:VCARD";
              
       return $vcard;
    }
}