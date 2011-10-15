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

App::uses('AppController', 'Controller');


/**
 * Provides case management. A case is considered anything note worthy.
 * @author Jason D Snider <jason.snider@42viral.org>
 */
class CasesController extends AppController {
    
    /**
     * This controller does not use a model
     *
     * @var array
     * @access public
     */
    public $uses = array('CaseModel');    
    
    /**
     * 
     * @param type $id 
     */
    public function admin_view($id){
        
        $case = $this->CaseModel->fetchCaseWith($id, 'standard');
        
        if(!empty($case['Person'])){
            $userProfile['Person'] = $case['Person'];
            $this->set('userProfile', $userProfile);
        }
        
        $this->set('case', $case);
        $this->set('title_for_layout', $case['CaseModel']['subject']);
    }
}
