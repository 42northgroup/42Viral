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
define('IMAGE_THUMB_DIM_2', 120);

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