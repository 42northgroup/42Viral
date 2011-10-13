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
 * The domains fully configured base url
 */
Configure::write('Domain.url', Configure::read('Domain.scheme') . '://' . Configure::read('Domain.host') . '/');

/**
 * From email address to use in the header when sending out emails using the email component
 */
Configure::write('Email.from', 'app@42viral.org');

/**
 * Reply to email address to use in the header when sending out emails using the email component
 */
Configure::write('Email.replyTo', 'support@42viral.org');

/**
 * Are we in private beta mode?
 */
Configure::write('Beta.private', 0);

Configure::write('Shorty', 
        array(
            'page'=>Configure::read('ShortURL.scheme') . '://' . Configure::read('ShortURL.host') . '/' 
                . Configure::read('ShortURL.Pointer.page').'/',
            
            'blog'=>Configure::read('ShortURL.scheme') . '://' . Configure::read('ShortURL.host') . '/' 
                . Configure::read('ShortURL.Pointer.blog').'/',
            
            'post'=>Configure::read('ShortURL.scheme') . '://' . Configure::read('ShortURL.host') . '/' 
                . Configure::read('ShortURL.Pointer.post').'/'
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
 * The maximum allowable width for image uploads to use for proportional image shrinks
 */
define('IMAGE_AUTO_SHRINK', true);

/**
 * Thumbnail dimension for uploaded images - Dimension 1
 */
define('IMAGE_THUMB_DIM_1', 75);

/**
 * Thumbnail dimension for uploaded images - Dimension 2
 */
define('IMAGE_THUMB_DIM_2', 166);

/**
 * The maximum allowable width for image uploads to use for proportional image shrinks
 */
define('IMAGE_SHRINK_WIDTH', 400);

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

/* ================
 * == Comments ====
 * =============== */

/**
 * Configure the systems default commenting engine
 * Comment engines
 *     native - 42Viral's native comment engine (Default)
 *     //See Thrid Party API's for additional configuration
 */
Configure::write('Comment.engine', 'native');

/* =========================
 * == Thrid Party API's ====
 * ======================= */

Configure::write('Twitter.callback', Configure::read('Domain.url') . 'oauth/twitter_callback');


/* ====================
 * == Asset Helper ====
 * ================== */
//Configuration options for asset management and optimization

/*
 * JS_METHOD: (JavaScript minification method to use)
 *     jsMin         - http://code.google.com/p/minify/
 *     closureRemote - Google closure compiler using CURL
 *     closureLocal  - Uses a local clouser complier.jar
 *     yuiLocal      - Uses a local yui jar file
 */
define('JS_METHOD', 'closureLocal');

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
define('ASSET_CACHE', ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS . 'cache');

/**
 * ASSET_FILES (The top level directory to the client assest via the server path)
 */
define('ASSET_FILES', ROOT . DS . APP_DIR . DS . WEBROOT_DIR . DS);

/**
 * JAVA (Sets the location of the Java binary
 */
define('JAVA', DS . 'usr' . DS . 'bin' . DS . 'java');

/**
 * CLOSURE (Sets the location of the closure-compiler jar file)
 */
define('CLOSURE', ROOT . DS . APP_DIR . DS . 'Vendor' . DS . 'minify' . DS . 'closure' . DS . 'compiler.jar');

/**
 * YUI (Sets the location of the YUI Compressor jar file)
 */
define('YUI', ROOT . DS . APP_DIR . DS . 'Vendor' . DS . 'minify' . DS . 'yui' . DS . 'yuicompressor-2.4.6.jar');

/**
 * Allows us to choose not to minify, good for debugging
 */
define('MINIFY_ASSETS', true);

/**
 * When set to true this overrides the native hash checking functionality and forces a new asset build
 */
define('FORCE_NEW_ASSETS', false);

/**
 * Privide a standard warning for all purges/hard deletions
 */
Configure::write('System.purge_warning',
                    __('Are you sure you want to delete this? \n This action CANNOT be reversed!')); 