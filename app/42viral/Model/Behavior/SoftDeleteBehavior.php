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
 * This model behavior will log the user who created or modified a record
 *
 * @package app
 * @subpackage app.core
 *** @author Zubin Khavarian <zubin.khavarian@42viral.org>
 */
class SoftDeleteBehavior extends ModelBehavior
{

    function setup(&$model)
    {

    }

    public function softDelete(&$model, $conditions)
    {
        if(is_array($conditions)){
            $people = $model->find('all', array('conditions'=>$conditions) );
            
            foreach($people as $person){
                $person['Person']['deleted_person_id'] = $this->__getUser();
                $person['Person']['deleted'] = date('Y-m-d H:i:s');
                $model->save($person);
            }
            
        }else{        
        
            $person = $model->findById($conditions);
            $person['Person']['deleted_person_id'] = $this->__getUser();
            $person['Person']['deleted'] = date('Y-m-d H:i:s');
            
            $model->save($person);
        }
        return true;
    }

    /**
     *
     * @return string
     * @access private
     */
    private function __getUser()
    {
        if (isset($_SESSION['Auth']['User']['id'])) {
            return $_SESSION['Auth']['User']['id'];
        } else {
            return '4e24236d-6bd8-48bf-ac52-7cce4bb83359';
        }
    }

    /**
     * @param object $model
     * @return void
     * @access private
     */
    private function __appendSoftDeleteFields(&$model)
    {
        $model->data[$model->name]['deleted_person_id'] = $this->__getUser();
        $model->data[$model->name]['deleted'] = date('Y-m-d H:i:s');
    }

}
