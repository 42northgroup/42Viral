<?php
App::uses('DboSource', 'Model/Datasource');
class No extends DboSource{
    var $description = "This is a dummy data source";
    function connect()
    {
        $this->connected = true;
        return $this->connected;
    }
    
    function disconnect()
    {
        $this->connected = true;
        return !$this->connected;
    }
    
    function value($string)
    {
        return "\0".$string."\0";
    }
    
    function execute(){
        return array();
    }
}