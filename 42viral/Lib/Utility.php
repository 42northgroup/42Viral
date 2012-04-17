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
App::import('Vendor', 'Markdown', array('file' => 'Markdown' . DS . 'markdown.php'));

/**
 * A utility class for managing plugin configurations
 * 
 * @package Lib
 * @author Jason D Snider <jason.snider@42viral.org>
 */
class Utility
{

    /**
     * Noramlizes configuration data so it can easily be saved to the configurations table
     *
     * @access public
     * @static
     * @param array $data
     * @return array
     */
    public static function pluginConfigWrite($data)
    {
        $config = array();
        $x = 0;

        foreach ($data as $key => $value) {
            $config[$x]['Configuration']['id'] = $value['id'];
            $config[$x]['Configuration']['value'] = $value['value'];
            $x++;
        }
        
        return $config;
    }

    /**
     * Parses and restructures configuration data so that it is automatically read by configuration forms.
     *
     * @access public
     * @static
     * @param array $data
     * @return array
     */
    public static function pluginConfigRead($data)
    {
        $reconfig = array();
        $i = 0;
        
        foreach ($data as $config) {
            foreach ($config as $k => $v) {
                $reconfig[str_replace('.', '', $v['id'])] = $v;
                $i++;
            }
        }
        
        return $reconfig;
    }

    /**
     * Returns false if a host is unreachable
     *
     * @access public
     * @static
     * @param string $server
     * @param integer $port
     * @return boolean
     */
    public static function connectionTest($server, $port = 80)
    {
        $fp = fsockopen($server, $port, $errno, $errstr, 10);
        
        if (!$fp) {
            CakeLog::write('SocketError', "SERVER {$server} PORT {$port} ({$errno}/{$errstr})");
            return false;
        } else {
            return true;
            fclose($fp);
        }
    }

    /**
     * Parses text as markdown and converts it to HTML
     *
     * @access public
     * @static
     * @param string $text
     * @return string
     */
    public static function markdown($text)
    {
        return Markdown($text);
    }

}