<?php
/**
 * The server write path to external libraries and appilications
 */
define('SERVER_LIBRARY', DS . 'var' . DS . 'www' . DS . 'server-libraries');

/*
 * JS_METHOD: (JavaScript minification method to use)
 *     jsMin         - http://code.google.com/p/minify/
 *     closureRemote - Google closure compiler using CURL
 *     closureLocal  - Uses a local clouser complier.jar
 *     yuiLocal      - Uses a local yui jar file
 */
define('JS_METHOD', 'closureRemote');

/**
 * CSS_METHOD: (CSS minification method to use)
 *     cssMin - http://code.google.com/p/cssmin/
 *     yuiLocal      - Uses a local yui jar file
 * 
 */
define('CSS_METHOD', 'yuiLocal');

/**
 * ASSET_CACHE (The location of the cache directory, this is where the single asset file will be written via the server 
 * path) 
 */
define('ASSET_CACHE', ROOT . DS . 'cache');

/**
 * ASSET_FILES (The top level directory to the client assest via the server path)
 */
define('ASSET_FILES', ROOT);

/**
 * JAVA (Sets the location of the Java binary
 */
define('JAVA', DS . 'usr' . DS . 'bin' . DS . 'java');

/**
 * CLOSURE (Sets the location of the closure-compiler jar file)
 */
define('CLOSURE',  SERVER_LIBRARY . DS  .'apps' . DS . 'closure' . DS . 'compiler.jar');

/**
 * YUI (Sets the location of the YUI Compressor jar file)
 */
define('YUI', SERVER_LIBRARY . DS . 'apps' . DS . 'yui' . DS . 'build' . DS . 'yuicompressor-2.4.6.jar');


/**
 * Helper class for merging client side assets
 * 1. Make sure ASSET_CACHE . DS . cache is writable by the server
 * 2. If runing local Java based minifiers, make sure the jar files are accessable by the web server
 * 
 * CONSTANTS - To these may be set in core.php or any $config extension. If these are not set their values will be 
 * set in the constructor. 
 * 
 * define('JS_METHOD', 'closureLocal');
 * define('CSS_METHOD', 'yuiLocal');     
 * define('ASSET_CACHE', ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS . 'cache');
 * define('ASSET_FILES', ROOT . DS . APP_DIR . DS . WEBROOT_DIR);
 * define('JAVA' , DS . 'usr' . DS . 'bin' . DS . 'java');
 * define('CLOSURE', DS . 'path_to' . DS . 'compiler.jar');    
 * define('YUI', DS . 'path_to' . DS . 'yuicompressor-x.x.x.jar');
 * 
 * Copyright (c) 2011,  MicroTrain Technologies (http://www.microtrain.net)
 * licensed under MIT (http://www.opensource.org/licenses/mit-license.php)
 *
 * @copyright Copyright 2010, MicroTrain Technologies (http://www.microtrain.net)
 * @package Optimization
 * @author Jason Snider <jsnider77@gmail.com>
 * @author Zubin Khavarian <zubin.khavarian@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class AssetHelper extends Helper
{

    /**
     * Are we processing JS or CSS?
     * 
     * @access private
     * @var string 
     */
    private $__assetType;
    /**
     * Allows us to turn off minification
     * 
     * @access private 
     * @var boolean 
     */
    private $__doMinify = true;
    /**
     * Specifies the proper javascript minification solution
     * 
     * @access private
     * @var string 
     */
    private $__jsMethod;
    /**
     * Specifies the proper css minification solution
     * 
     * @access private
     * @var string
     */
    private $__cssMethod;
    /**
     * The location of your web accessable cache directory. typically this is webroot/cache
     * webroot
     * |-cache
     *  |-js
     *  |-css
     * 
     * @access private
     * @var string
     */
    private $__assetCache;
    /**
     * The the location of your assets top level directory, typically this is webroot. 
     * webroot
     * |-js
     * |-css
     * 
     * @access private
     * @var string
     */
    private $__assetFiles;
    /**
     * 
     * 
     * @access private
     * @var array
     */
    private $__assetContainer_Css = array();
    /**
     * 
     * @access private
     * @var array()
     */
    private $__assetContainer_Js = array();
    /**
     * Defines the path to the JAVA binary, typically /usr/bin/java
     * 
     * @access private
     * @var string 
     */
    private $_java;
    /**
     * Defines the path to the YUI Compressor jar file. This MUST be accessable by the web server
     * 
     * @access private
     * @var type 
     */
    private $_yui;
    /**
     * Defines the path to the Closure Compiler jar file. This MUST be accessable by the web server
     * 
     * @access private
     * @var type 
     */
    private $_closure;
    
    /**
     * Allows us to shut off doMinify in very rare situations
     * 
     * @access private
     * @var boolean
     */
    private $__overRide;
    
    
    /**
     * Store to hold asset package definitions from configuration file
     * @access private
     * @var array
     */
    private $__packageDef = null;


    /**
     * This doesn't really do much, but it does allow us to break the connection to core.php, and for that matter
     * 
     * CakePHP all togeather.
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
        
        //Use the asset_packages.php config file to initialize the package definitions
        require(APP . '/config/asset_packages.php');
        $this->__packageDef = $assetPackages;

        if (defined('MINIFY_ASSETS')) {
            $this->__doMinify = MINIFY_ASSETS;
        }

        if (defined('JS_METHOD')) {
            $this->__jsMethod = JS_METHOD;
        }

        if (defined('CSS_METHOD')) {
            $this->__cssMethod = CSS_METHOD;
        }

        if (defined('ASSET_CACHE')) {
            $this->__assetCache = ASSET_CACHE;
        }

        if (defined('ASSET_FILES')) {
            $this->__assetFiles = ASSET_FILES;
        }

        if (defined('JAVA')) {
            $this->_java = JAVA;
        }

        if (defined('CLOSURE')) {
            $this->_closure = CLOSURE;
        }

        if (defined('YUI')) {
            $this->_yui = YUI;
        }
    }

    /**
     * Set the minify boolean to allow us to turn minification on and off
     * 
     * @param type $status 
     */
    public function setDoMinify($status)
    {
        $this->__doMinify = ($status) ? true : false;
    }

    /**
     * Returns the value of the minify boolean
     * 
     * @return boolean
     */
    public function getDoMinify()
    {
        return ($this->__doMinify) ? true : false;
    }

    /**
     * Allows us to set a different means of minification
     * 
     * @param string $method
     * @param string $type 
     */
    public function setMinifyMethod($method, $type = 'js')
    {
        ($type == 'js') ? $this->__jsMethod = $method : $this->__cssMethod = $method;
    }

    /**
     * Retruns the current minification method for any 
     * 
     * @param string $type
     * @return string 
     */
    public function getMinifyMethod($type = 'js')
    {
        return ($type == 'js') ? $this->__jsMethod : $this->__cssMethod;
    }

    /**
     * Builds the asset queues
     * 
     * @access public
     * @param array $assets 
     */
    public function addAssets($assets, $group='default')
    { 
        for ($i = 0; $i < count($assets); $i++) {
            $assetType = $this->__findAssetType($assets[$i]);

            if (!isset($this->__assetContainer_Css[$group])) {
                $this->__assetContainer_Css[$group] = array();
            }

            if (!isset($this->__assetContainer_Js[$group])) {
                $this->__assetContainer_Js[$group] = array();
            }

            //Direct the incoming assets to their dedicated containers
            if ($assetType == 'css') {
                array_push($this->__assetContainer_Css[$group], $assets[$i]);
            } elseif ($assetType == 'js') {
                array_push($this->__assetContainer_Js[$group], $assets[$i]);
            } else {
                //Do nothing (ignore invalid asset type)
            }
        }
    }

    /**
     * Allows an over ride flag to be set against the minify parameter. This can only 
     * prevent minification, this will never flip a false doMinify condition to true
     * 
     * @access private
     * @param boolean $overRide 
     */
    private function __overRide($overRide){
        if($overRide){
            $this->__overRide == true;
        }else{
            $this->__overRide == false;
        }
    }
    
    /**
     * Given the asset path decide what asset type it is
     * 
     * @access private
     * @param type $assetPath 
     * @return string asset type
     */
    private function __findAssetType($assetPath)
    {
        if (preg_match("/(.*).css$/i", $assetPath)) {
            return 'css';
        } elseif (preg_match("/(.*).js$/i", $assetPath)) {
            return 'js';
        } else {
            return '';
        }
    }

    /**
     * Recursivly concatantes all /path/file.ext + ctime for each asset in the array. 
     * The resulting string is hashed.
     * 
     * @access private
     * @param array $assets
     * @return string 
     */
    private function __hashAssets($assets)
    {
        $file = '';
        $ctime = '';
        $stringToHash = '';

        for ($i = 0; $i < count($assets); $i++) {
            $file = $this->__assetFiles . DS . $this->__assetType . DS . $assets[$i];
            $ctime = filectime($this->__assetFiles . DS . $assets[$i]);
            $stringToHash .= "{$file}{$ctime}";
        }

        if ($this->__doMinify) {
            /* Append different string based on requested minification state and method to use in order to generate
             * unique hashes for different combinations to avoid caching problems when switching things
             */
            $stringToHash .= 'minified';
            $stringToHash .= ( $this->__assetType == 'js') ? $this->__jsMethod : $this->__cssMethod;
            if (FORCE_NEW_ASSETS) {
                $stringToHash .= rand('0', '9999');
            }
        }

        return hash('md5', $stringToHash);
    }

    /**
     * Writes all assets to a single file
     * 
     * @access private
     * @param array $assets
     * @param string $file 
     * @return void
     */
    private function __write($assets, $file)
    {
        $contents = '';
        $fh = fopen($file, 'w') or $this->log("Can't create a cache file", 'AssetHelper');
        for ($i = 0; $i < count($assets); $i++) {
            $file = $this->__assetFiles . DS . $assets[$i];
            $contents .= ' ' . file_get_contents($file) or $this->log("Can't read a cached file", 'AssetHelper');
        }
                
        $contents = $this->__minify($contents);
        
        fwrite($fh, $contents);
        fclose($fh);
    }

    /**
     * Minifies the contents of a given string based on configuration parameters
     * 
     * @access private
     * @param string $contents
     * @return string
     */
    private function __minify($contents)
    {
        //So long as we all agree we are minifing and we do not need to over ride the configuration, go ahead
        if ($this->__doMinify && !$this->__overRide) { 
            if ($this->__assetType == 'js') {

                switch ($this->__jsMethod) {

                    case 'closureRemote':
                        $minifiedContent = $this->__closureRemote($contents);
                        break;

                    case 'closureLocal':
                        $minifiedContent = $this->__closureLocal($contents);
                        break;

                    case 'yuiLocal':
                        $minifiedContent = $this->__yuiLocal($contents);
                        break;

                    case 'jsMin':
                        $minifiedContent = $this->__cssMin($contents);
                        break;

                    default:
                        $minifiedContent = $contents;
                        break;
                }
            } else {

                switch ($this->__cssMethod) {

                    case 'yuiLocal':
                        $minifiedContent = $this->__yuiLocal($contents, 'css');
                        break;

                    case 'cssMin':
                        $minifiedContent = $this->__cssMin($contents);
                        break;

                    default:
                        $minifiedContent = $contents;
                        break;
                }
            }
            
            return $minifiedContent;
            
        } else {

            return $contents;
        }
    }

    /**
     * Uses jsmin.php to minify css content
     * 
     * @access private
     * @param type $contents
     * @return type 
     */
    private function __jsMin($contents)
    {
        App::import('Vendor', 'jsMin', array('file' => 'minify' . DS . 'jsmin.php'));
        $minifiedContent = JsMin::minify($contents);
        
        if($this->__verify($minifiedContent)){
            return $minifiedContent;
        }else{
            $this->log("jsmin.php failed to minify JS content", 'AssetHelper');
            return $contents;
        }
    }

    /**
     * Uses cssmin.php to minify css content
     * 
     * @access private
     * @param type $contents
     * @return type 
     */
    private function __cssMin($contents)
    {
        App::import('Vendor', 'cssMin', array('file' => 'minify' . DS . 'cssmin-3.0.0.b7.php'));
        $minifiedContent = CssMin::minify($contents);
        if($this->__verify($minifiedContent)){
            return $minifiedContent;
        }else{
            $this->log("cssmin.php failed to minify CSS content", 'AssetHelper');
            return $contents;
        }
    }

    /**
     * Allows the remote usage of Google Clouser
     * 
     * @access private
     * @param type $contents
     * @return type 
     */
    private function __closureRemote($contents)
    {
        $ch = curl_init('http://closure-compiler.appspot.com/compile');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 
                "output_info=compiled_code"
                . "&output_format=text"
                . "&compilation_level=SIMPLE_OPTIMIZATIONS"
                . "&js_code="
                . urlencode($contents));
        $minifiedContent = curl_exec($ch);
        curl_close($ch);
        
        if($this->__verify($minifiedContent)){
            return $minifiedContent;
        }else{
            $this->log("closureReomte failed to minify JS content", 'AssetHelper');
            return $contents;
        }

    }

    /**
     * Allows you to use a local YUI jar file to minify your assets
     * Requires YUI compressor 
     * 
     * @access private
     * @see http://yuilibrary.com/downloads/#yuicompressor
     * @param type $contents
     * @param type $type
     * @return type 
     */
    private function __yuiLocal($contents, $type='js')
    {
        $tmpFile = $this->__addTmpFile($contents, $type);
        $minifiedContent = shell_exec(JAVA . " -jar " . YUI . " {$tmpFile} --type={$type}");
        $this->__removeTmpFile($tmpFile);
        
        if($this->__verify($minifiedContent)){
            return $minifiedContent;
        }else{
            $this->log("closureLocal failed to minify {$this->__assetType} content", 'AssetHelper');
            return $contents;
        }
    }

    /**
     * Allows you to use a local Closure jar file to minify your assets
     * Requires Google closure
     * 
     * @access private
     * @see http://code.google.com/closure/compiler/docs/gettingstarted_app.html 
     * @param type $contents
     * @return type 
     */
    private function __closureLocal($contents)
    {
        $fallback = $contents;
        $tmpFile = $this->__addTmpFile($contents, 'js');
        $minifiedContent = shell_exec(
                JAVA . " -jar " . CLOSURE 
                . " --js {$tmpFile}"
                . " --compilation_level SIMPLE_OPTIMIZATIONS"
                );

        $this->__removeTmpFile($tmpFile);
        
        if($this->__verify($minifiedContent)){
            return $minifiedContent;
        }else{
            $this->log("closureLocal failed to minify JS content", 'AssetHelper');
            return $contents;
        }
    }

    /**
     * Some minifiers, such as YUI require a file as opposed to string input, this creates a tmp file for that purpose
     * 
     * @access private
     * @param type $contents
     * @param type $type
     * @return string 
     */
    private function __addTmpFile($contents, $type)
    {
        $tmpFile = $this->__assetCache . DS . 'tmp' . DS . "tmp" . rand(1000, 9999) . ".{$type}";
        $fh = fopen($tmpFile, 'w') or die("can't open file");
        fwrite($fh, $contents);
        fclose($fh);

        return $tmpFile;
    }

    /**
     * Cleans up the tmp file after use
     * 
     * @access private
     * @param type $tmpFile 
     */
    private function __removeTmpFile($tmpFile)
    {
        unlink($tmpFile);
    }

    /**
     * Flush one of the two (js, css) asset queues, this will be used when calling buildAssets not to 
     * 
     * @access private
     * @param type $assetType 
     */
    private function __flushAssests($assetType, $group)
    {
        if ($assetType == 'js') {
            $this->__assetContainer_Js[$group] = array();
        } elseif ($assetType == 'css') {
            $this->__assetContainer_Css[$group] = array();
        }
    }
    
    /**
     * Tests the minified data and returns true if iti feels the minification process was successfull 
     * 
     * @access private
     * @param string $contents
     * @return boolean 
     * @todo Create a better tests
     */
    private function __verify($minifiedContent){
        $return = false;
        if(strlen($minifiedContent) > 0){
            $return = true;
        }
        return $return;
    }

    /**
     * Checkes for the existance of a file based on the hased sum of the assets array. If this exists then the 
     * asset reference is created. If this does does not exist then the file and its reference is created. 
     * 
     * @access public
     * @param string $assetType
     * @return string 
     */
    public function buildAssets($assetType, $group='default', $overRide=false)
    {
        $this->__assetType = $assetType;

        if ($assetType == 'css') {
            $assets = $this->__assetContainer_Css[$group];
        } elseif ($assetType == 'js') {
            $assets = $this->__assetContainer_Js[$group];
        }

        if (empty($assets)) {
            return '';
        }

        $fileName = $this->__hashAssets($assets) . ".{$this->__assetType}";
        $file = $this->__assetCache . DS . $this->__assetType . DS . $fileName;

        $write = true;
        
        //Do we need to overRide? If not we still need this to keep the instance sane.
        $this->__overRide($overRide);
        

        if (is_file($file) && filesize($file) != 0) {
            $write = false;
        }

        if ($write) {
            $this->__write($assets, $file);
        }

        if ($assetType == 'js') {

            $this->__flushAssests('js', $group);
            return "<script type=\"text/javascript\" src=\"/cache/{$this->__assetType}/{$fileName}\"></script>";
        } else {

            $this->__flushAssests('css', $group);
            return "<link rel=\"stylesheet\" type=\"text/css\" href=\"/cache/{$this->__assetType}/{$fileName}\" />";
        }
    }
    
    
    /**
     * Fetch a predefined asset package from config and automatically build and output css and js components
     * 
     * @author Zubin Khavarian <zkhavarian@microtrain.net>
     * @access public
     * @param type $packageName 
     * @return string
     */
    public function buildAssetPackage($packageName)
    {
        if(isset($this->__packageDef[$packageName])) {
            $packageSet = $this->__packageDef[$packageName];

            $this->addAssets($packageSet, $packageName);
            return $this->buildAssets('js', $packageName) . ' ' . $this->buildAssets('css', $packageName);
        } else {
            return '';
        }
        
    }

}

?>