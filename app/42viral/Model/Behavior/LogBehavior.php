<?php
/**
 * This model behavior will log the user who created or modified a record
 * 
 * @package app
 * @subpackage app.core
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 */
class LogBehavior extends ModelBehavior
{

    function setup(&$model) {}


    public function beforeSave(&$model)
    {
        $this->__appendLogFields($model);
        return true;
    }

    /**
     *
     * @return string
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access private
     */
    private function __getUser()
    { 
        if(isset($_SESSION['Auth']['User']['User']['id'])){
            return $_SESSION['Auth']['User']['User']['id'];
        }else{
            return '4e24236d-6bd8-48bf-ac52-7cce4bb83359';
        }
    }

    /**
     * @param object $model
     * @return void
     * @author Zubin Khavarian <zubin.khavarian@42viral.com>
     * @access private
     */ 
    private function __appendLogFields(&$model)
    {
        if(!isset($model->data[$model->name]['id'])) {
            $model->data[$model->name]['created_person_id'] = $this->__getUser();
        }
        
        $model->data[$model->name]['modified_person_id'] = $this->__getUser();
    }

}
