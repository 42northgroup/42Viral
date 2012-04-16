<?php
/**
 * A driver for running without a database
 * 
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package 42viral
 */
App::uses('DboSource', 'Model/Datasource');
/**
 * A driver for running without a database
 * @author Jason D Snider <jason.snider@42viral.org>
 * @link https://www.insecure.ws/2009/06/09/cakephp-without-a-database
 * @link http://www.sanisoft.com/blog/2008/08/22/using-cakephp-without-a-database/
 * @package 42viral
 */
class No extends DboSource{

    /**
     * Creates a connection to the No driver
     * @access public
     * @return boolean
     */
    public function connect()
    {
        $this->connected = true;
        return $this->connected;
    }

    /**
     * Disconnects from the No driver
     * @access public
     * @return boolean
     */
    public function disconnect()
    {
        $this->connected = true;
        return !$this->connected;
    }
    
    /**
     * I don't know what this does
     * @access public
     * @param string $string
     * @return string
     * @todo find out what this does
     */
    public function value($string)
    {
        return "\0".$string."\0";
    }
    
    /**
     * I don't know what this does
     * @access public
     * @return array
     * @todo find out what this does
     */
    public function execute(){
        return array();
    }
}