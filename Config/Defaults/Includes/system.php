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

/* ==============
 * == Themes ====
 * ============= */

/**
 * The platform identifies itsef as 42Viral
 */
Configure::write('42viral.platform', true);

/**
 * The domains fully configured base url
 */
Configure::write('Domain.url', Configure::read('Domain.scheme') . '://' . Configure::read('Domain.host') . '/');

/**
 * Are we in private beta mode?
 */
Configure::write('Beta.private', 0);

/**
 * If we are in private mode, how many invatations can a user send?(0 for infinite)
 */
Configure::write('Beta.invitations', 0);

Configure::write('Shorty',
        array(
            'page'=>Configure::read('ShortURL.scheme') . '://' . Configure::read('ShortURL.host') . '/'
                . 'a/',

            'blog'=>Configure::read('ShortURL.scheme') . '://' . Configure::read('ShortURL.host') . '/'
                . 'b/',

            'post'=>Configure::read('ShortURL.scheme') . '://' . Configure::read('ShortURL.host') . '/'
                . 'c/'
        ));
/* ====================
 * == File Uploads ====
 * ================== */
// The following helps generalize read/write path for user uploaded files and images
/**
 * The common part of image write paths
 */
define('IMAGE_WRITE_PATH', ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS . 'img' . DS . 'people' . DS);

/**
 * The common part of file write paths
 */
define('FILE_WRITE_PATH', ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS . 'files' . DS . 'people' . DS);

/**
 * The common part of web image urls
 */
define('IMAGE_READ_PATH', '/img/people/');

/**
 * The common part of file urls
 */
define('FILE_READ_PATH', '/files/people/');


/**
 * Encoding method to use for encoding and decoding the setup state array structure
 *
 * Options:
 *     php_serialize
 *     json
 */
if (!defined('SETUP_STATE_ENCODING_METHOD')) {
    define('SETUP_STATE_ENCODING_METHOD', 'php_serialize');
}

/* =========================
 * == Thrid Party API's ====
 * ======================= */

Configure::write('Twitter.callback', Configure::read('Domain.url') . 'oauth/twitter_callback');
Configure::write('Facebook.callback', Configure::read('Domain.url') . 'oauth/facebook_callback');
Configure::write('LinkedIn.callback', Configure::read('Domain.url') . 'oauth/linkedin_callback');
Configure::write('GooglePlus.callback', Configure::read('Domain.url') . 'oauth/google_callback');

/**
 * Privide a standard warning for all purges/hard deletions
 */
Configure::write('System.purge_warning',
                    __('Are you sure you want to delete this? \n This action CANNOT be reversed!'));

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
    ROOT .DS. APP_DIR .DS. '42viral' .DS. 'Vendor' .DS. 'minify' .DS. 'closure' .DS. 'compiler.jar'
);

/**
 * YUI (Sets the location of the YUI Compressor jar file)
 * @var string
 */
define(
    'YUI',
    ROOT .DS. APP_DIR .DS. '42viral' .DS. 'Vendor' .DS. 'minify' .DS. 'yui' .DS. 'build' .DS.'yuicompressor-2.4.6.jar'
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