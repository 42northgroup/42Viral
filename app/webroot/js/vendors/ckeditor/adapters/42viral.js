/**
 * JavaScript
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

/**
 ** @author Jason D Snider <jason.snider@42viral.org>
 */

/**
 *If we are going to combine and minify, this file must be called before ckeditor 
 */
var CKEDITOR_BASEPATH = "/js/vendors/ckeditor/";

/**
 * Configure CKEditor instances
 */
$(function(){
    
    var configContent = {
        toolbar_Content : [
            ['Source', '-', 
                'Format', 'Bold', 'Italic', 'Underline', 'Strike', '-',
                'Link', 'Image','-',
                'SelectAll','RemoveFormat', '-',
                'NumberedList','BulletedList', '-',
                'SpellChecker', 'Scayt',
                'About']
        ],
        
        toolbar : 'Content',
        extraPlugins : 'autogrow',
        scayt_autoStartup : true,
        /*toolbarStartupExpanded : false,*/
        basePath : '/ckeditior/',
        contentsCss : ['/css/vendors/yui.css', '/css/fonts.css'],
        skin: 'v2'
                
    };
    
    var configBasic = {

        toolbar_Basic : [
            ['Bold', 'Italic', 'Underline', 'Strike', '-',
                'Link', '-',
                'SelectAll','RemoveFormat', '-',
                'NumberedList','BulletedList', '-',
                'SpellChecker', 'Scayt',
                'About']
        ],
        
        toolbar : 'Basic',
        extraPlugins : 'autogrow',
        scayt_autoStartup : true,
        /*toolbarStartupExpanded : false,*/
        basePath : '/ckeditior/',
        contentsCss : ['/css/vendors/yui.css', '/css/fonts.css'],
        skin: 'v2'
                
    };
    
    $('.edit-content').ckeditor(configContent);
    $('.edit-basic').ckeditor(configBasic); //Default
    
});
