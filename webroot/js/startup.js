/**
 * JavaScript
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
 * Configures and initializes sitewide functionality 
 * 
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Zubin Khavarian (https://github.com/zubinkhavarian)
 * @author Lyubomir R Dimov <lubo.dimov@42viral.org>
 */

/**
 * Default application wide AJAX settings 
 */
$.ajaxSetup ({
    // Disable caching of AJAX responses
    cache: false
});

/**
 * Provides functionality for header navigation.
 */
var HeaderNavigation = {
    /**
     * Prepares functionality for use in the UI
     * @return void
     * @access public
     */
    setupUI: function() {
        
        //Controls clickable navigation on small devices
        $("#NavigationTrigger, #MobileNavigationTrigger").click(function(){
            if($('#Navigation').is(':visible')) {
                $('#Navigation').attr('style', '');
            } else {
                $('#Navigation').show();
            }
        });

        //Controls mouseover navigation on large devices
        $('#Navigation').delegate('.navigation', 'mouseenter',function() {
            $(this).addClass('active');
            $(this).find('div.subnavigation:first').show();
        });

        $('#Navigation').delegate('.navigation', 'mouseleave',function() {
            $(this).removeClass('active');
            $(this).find('div.subnavigation:first').hide();
        });           
    },

    /**
     * Builds the UI interactions
     * 
     * @return void
     * @access public
     */
    init: function() {
        this.setupUI();
    }
};

// "Instansiates prototypical objects"
$(function(){
    HeaderNavigation.init();
});