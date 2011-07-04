<?php
class Person extends AppModel
{
    
    function getPerson($id){
        $person = $this->find('first', array('conditions'=>array('Person.id' => $id)));
        return $person;
    }
    
}
?>
