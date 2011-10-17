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
 * Functionality for sending out invites, this was inspired by a need for private beta,
 *** @author Jason D Snider <jason.snider@42viral.org>
 */
class Invite extends AppModel
{
    /**
     * 
     * @var string
     * @access public
     */
    public $name = 'Invite';
    
    /**
     * 
     * @var string
     * @access public
     */
    public $useTable = 'invites';
    
    /**
     * Confirms an invite token
     * @var string id
     * @return boolean
     * @access public
     */
    public function confirm($id){
        
        $invite = $this->find('first', array('conditions'=>array('Invite.id'=>$id, 'Invite.accepted IS NULL')));
        
        if(empty($invite)){
            return false;
        }else{
            return true;
        }
        
        return false;
    } 
    
    /**
     * Invalidates a used invite token
     * @var string id
     * @return boolean
     * @access public
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
     * @param integer $count 
     * @return boolean
     * @access public 
     */
    public function add(){
        $this->Invite->create();
        if($this->Invite->save()){
            return true;
        }else{
            return false;
        }
    }
}