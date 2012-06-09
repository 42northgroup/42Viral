<?php
/**
 * Mangages a users profile data
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Visssral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package       42viral\Person\User\Profile
 */

App::uses('AppModel', 'Model');
/**
 * Mangages a users profile data
 *
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 * @package       42viral\Person\User\Profile
 */
class Profile extends AppModel
{
    /**
     * Model name
     *
     * @var string
     * @access public
     */
    public $name = 'Profile';
    
    /**
     * Table the model uses
     * @var string
     * @access public
     */
    public $useTable = 'profiles';
    
    /**
     * Predefined data sets
     * @var array
     * @access public 
     */
    public $dataSet = array(

        'nothing'=>array(
            'contain'=>array()
        ),
        'person' => array(
            'contain' =>    array(
                'Person'=>array()
            ),
            'conditions' => array()
        )
    ); 
    
    /**
     * belongsTo
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
     * Defines the person model's has many relationships
     * @access
     * @var array
     */
    public $hasMany = array(
        'SocialNetwork' => array(
            'className' => 'Connect.SocialNetwork',
            'foreignKey' => 'profile_id',
            'dependent' => true
        )
    );
    
    /**
     * Behaviors
     * @var array
     * @access public
     */
    public $actsAs = array(
        'ContentFilters.Scrubable' => array(
            'Filters' => array(
                'trim' => '*',
                'htmlStrict' => array('bio', 'body')
            )
        )
    );

    /**
     * Returns a person's profile data with the specified associated data. 
     * 
     * @param string $token - The profile id
     * @param string $with
     * @return array
     * @access public
     */
    public function getProfileWith($token, $with = 'nothing')
    {
        $theToken = array('conditions'=>array('Profile.id' => $token));
        
        $finder = array_merge($this->dataSet[$with], $theToken);
        
        $userProfile = $this->find('first', $finder);
        
        return $userProfile;
    }
   
   /**
    * Uses the information from the user profile to build an xCard
    * 
    * @access public
    * @param array $profile
    * @return string 
    */
   public function getXcard($profile)
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
    public function getVcard($profile, $version)
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