<?php
/**
 * A placeholder for experimenting
 */
class AppTestsController extends AppController {
    
    var $uses = array();
    
    public function index(){
        $this->loadModel('Contact');
        
        pr($this->Contact->find('all'));
    }  
    

}

?>
