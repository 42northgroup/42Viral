<?php
/**
 * A placeholder for experimenting
 */
class AppTestsController extends AppController {
    
    var $uses = array();
    
    public function index(){
        $this->loadModel('Person');
       // pr($this->Person->find('all'));
        
        pr($this->Person->getPerson('c9510606-a5bf-11e0-8563-000c29ae9eb4'));
    }
    
    
    
}

?>
