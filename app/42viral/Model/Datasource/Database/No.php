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
App::uses('DboSource', 'Model/Datasource');
/**
 * A driver for running without a database
 * @see https://www.insecure.ws/2009/06/09/cakephp-without-a-database
 * @see http://www.sanisoft.com/blog/2008/08/22/using-cakephp-without-a-database/
 */
class No extends DboSource{

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