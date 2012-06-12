<?php

/* ====================
 * == Asset Helper ====
 * ================== */
//Configuration options for asset management and optimization

/**
 * JS_METHOD: (JavaScript minification method to use)
 *     jsMin         - http://code.google.com/p/minify/
 *     closureRemote - Google closure compiler using CURL
 *     closureLocal  - Uses a local clouser complier.jar
 *     yuiLocal      - Uses a local yui jar file
 * @var string
 */
define('JS_METHOD', 'closureLocal');

/**
 * CSS_METHOD: (CSS minification method to use)
 *     cssMin - http://code.google.com/p/cssmin/
 *     yuiLocal      - Uses a local yui jar file
 * @var string
 */
define('CSS_METHOD', 'yuiLocal');

/**
 * ASSET_CACHE (The location of the cache directory, this is where the single asset file will be written via the server
 * path)
 * @var string
 */
define('ASSET_CACHE', ROOT .DS. APP_DIR .DS. WEBROOT_DIR .DS. 'cache');

/**
 * ASSET_FILES (The top level directory to the client assest via the server path)
 * @var string
 */
define('ASSET_FILES', ROOT .DS. APP_DIR .DS. WEBROOT_DIR . DS);

/**
 * JAVA (Sets the location of the Java binary
 * @var string
 */
define('JAVA', DS . 'usr' .DS. 'bin' .DS. 'java');

/**
 * CLOSURE (Sets the location of the closure-compiler jar file)
 * @var string
 */
define(
    'CLOSURE',
    ROOT .DS. APP_DIR .DS. 'Plugin' .DS. 'AssetManager' .DS.
        'Vendor' .DS. 'minify' .DS. 'closure' .DS. 'compiler.jar'
);

/**
 * YUI (Sets the location of the YUI Compressor jar file)
 * @var string
 */
define(
    'YUI',
    ROOT .DS. APP_DIR .DS. 'Plugin' .DS. 'AssetManager' .DS.
        'Vendor' .DS. 'minify' .DS. 'yui' .DS. 'build' .DS.'yuicompressor-2.4.6.jar'
);

/**
 * Allows us to choose not to minify, good for debugging
 * @var boolean
 */
define('MINIFY_ASSETS', true);

/**
 * When set to true this overrides the native hash checking functionality and forces a new asset build
 * @var boolean
 */
define('FORCE_NEW_ASSETS', false);

//// Define the paths to vaious versions of assets ////

/**
 * Sets the path to the current jQuery version
 * @var string
 */
define('CURRENT_JQUERY', 'vendors' . DS . 'jquery' . DS . 'js' . DS . 'jquery-1.7.2.js');

/**
 * Sets the path to the current Modernizr version
 * @var string
 */
define('CURRENT_MODERNIZR', 'vendors' . DS . 'modernizr' . DS . 'js' . DS . 'modernizr.js');