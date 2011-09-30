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


App::uses('Invite', 'Model');

/**
 * Component class for managing invites
 * @author Jason D Snider <jason.snider@42viral.org>
 */

class InviteComponent  extends Component
{
    
    var $components = array('Session'); 

    public function __construct(ComponentCollection $collection, $settings = array())
    {
        parent::__construct($collection, $settings);

        $this->Invite = new Invite();
    }
    
    /**
     * Adds a number invites to the database
     */
    public function create($emails){
        //$emails = array(1,2,3,4,5,6,7,8,9,10,11,12,13);
        for($i=0; $i<count($emails); $i++){
            $this->Invite->create();
            $this->Invite->save();
        }
    }
    
    
    /**
     * Confirms an invite
     */
    public function confirm($id){
        $data['Invite']['id'] = $id;
        $data['Invite']['accepted'] = date('Y-m-d h:i:s');
        $this->Invite->save($data);
    }    
    
}
