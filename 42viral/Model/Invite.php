<?php
/**
 * Functionality for sending out invites
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
 * @package 42viral\Invite
 */

App::uses('AppModel', 'Model');
/**
 * Functionality for sending out invites
 * @author Jason D Snider <jason.snider@42viral.org>
 * @package 42viral\Invite
 */
class Invite extends AppModel
{
    /**
     * The static name of the invite class 
     * @access public
     * @var string
     */
    public $name = 'Invite';
    
    /**
     * Specifies the table used by the invite object
     * @access public
     * @var string
     */
    public $useTable = 'invites';
    
    /**
     * Returns true if am invite token exists. 
     * Used to confirms an invite token.
     * @param string id The primary key column of the invites table
     * @return boolean
     * @access public
     */
    public function confirm($id){
        
        $invite = $this->find('first',
                array(
                        'conditions'=>array(
                            'Invite.id'=>$id, 'Invite.accepted IS NULL'
                        ),
                        'contain'=>array()
                    )
                );
        
        if(empty($invite)){
            return false;
        }else{
            return true;
        }
        
        return false;
    } 
    
    /**
     * Invalidates a used invite token
     * @access public
     * @param string id
     * @return boolean
     */
    public function accept($id){
            $data['Invite']['id'] = $id;
            $data['Invite']['accepted'] = date('Y-m-d h:i:s');
        if($this->save($data)){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Adds an invite to the invites table. This invite will be creditied to the logged in user.
     * @access public 
     * @return boolean
     */
    public function add(){
        $this->create();
        if($this->save()){
            return true;
        }else{
            return false;
        }
    }
}