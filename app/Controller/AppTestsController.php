<?php
/**
 * A placeholder for experimenting
 */
class AppTestsController extends AppController {
    
    var $uses = array();
    
    public function index(){
        
        $this->loadModel('User'); 
        
        $data['User']['username'] = 'bob';
        $data['User']['email'] = 'bob@demo.com';
        $data['User']['password'] = '12345';

          
        $this->User->createUser($data['User']);
    }  
    

}

?>
