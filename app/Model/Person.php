<?php

App::uses('AppModel', 'Model');

/**
 * Mangages the person object
 * @package App
 * @subpackage App.core
 */
class Person extends AppModel
{
    /**
     * Returns the data for a single person
     * @param string $id
     * @return array 
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public 
     */
    public function getPerson($id)
    {
        $person = $this->find('first', array('conditions'=>array('Person.id' => $id)));
        return $person;
    }
    
    /**
     * Creates a single person
     * @param array $data 
     * @param string $scope
     * @return array
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public 
     */
    public function newPerson($data)
    {
        
    }
    
    /**
     * Checks for duplicates by email
     * @return array
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public 
     */
    protected function _dupEmail($data)
    {
        
    }   
    
    /**
     * Checks for duplicates by screen name
     * @return array
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public 
     */
    protected function _dupScreenName($data)
    {
        
    } 
    
    /**
     * Checks for duplicates by name
     * @return array
     * @author Jason D Snider <jsnider77@gmail.com>
     * @access public 
     */
    protected function _dupNames(){
        
    }
}
?>
