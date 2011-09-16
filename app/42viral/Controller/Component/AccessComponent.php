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

/**
 * Helps deal with system access type of stuff
 * @package app
 * @subpackage app.core
 ** @author Jason D Snider <jason.snider@42viral.org>
 */
class AccessComponent  extends Component 
{

    
    public $components = array('Acl', 'Session');
    
    /**
     * Builds a list of privledges based on AROs ACOs
     * @param string $user
     * @return void
     * @see http://bakery.cakephp.org/articles/aalexgabi/2011/07/26/override_htmlhelper_for_acl_component_hide_links_where_users_don_t_have_privileges
     */
    public function permissions($user){

        $permissions = array();
        
        //Get the authenticated user 
        $userId = $user['id'];

        $acos = $this->Acl->Aco->children(); 
        foreach ($acos as $aco) { 
            $tmpacos = $this->Acl->Aco->getPath($aco['Aco']['id']); 
            $path = array(); 
            foreach ($tmpacos as $tmpaco) { 
                $path[] = $tmpaco['Aco']['alias']; 
            } 
            $stringPath = implode('/', $path); 
            if ($this->Acl->check(array('model' => 'User', 'foreign_key' => $userId), $stringPath)) 
                $permissions[$stringPath] = true; 
        } 
        $this->Session->write('Auth.User.Permissions', $permissions); 


    }
    
}