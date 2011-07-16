<?php
/**
 * This model behavior will log the user who created or modified a record
 * 
 * @package app
 * @subpackage app.core
 * @author Zubin Khavarian <zkhavarian@microtrain.net>
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
     * @author Zubin Khavarian <zkhavarian@microtrain.net>
     * @access private
     */
    private function __getUser()
    { 
        return $_SESSION['Auth']['User']['User']['id'];
    }

    /**
     * @param object $model
     * @return void
     * @author Zubin Khavarian <zkhavarian@microtrain.net>
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
