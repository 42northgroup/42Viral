<?php
/**
 * Configuration for pre-defined asset packages
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
 * @package 42viral\AssetManager
 */

/**
 * Stores preset asset package collections
 *
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @package 42viral\AssetManager
 */
class AssetPackage
{
    public static $presets = array(
        'jquery' => array(
            CURRENT_JQUERY
        ),

        'ck_editor' => array(
            'vendors/ckeditor/adapters/42viral.js',
            'vendors/ckeditor/ckeditor.js',
            'vendors/ckeditor/adapters/jquery.js'
        ),

        'selectit' => array(
            'vendors/selectit-0.1/js/jquery.selectit.js',
            'vendors/selectit-0.1/css/jquery.selectit.css'
        )
    );
}

?>