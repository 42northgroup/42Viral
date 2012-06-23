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
 * Auto-growing textareas; technique ripped from Facebook
 * @see http://goo.gl/rKtfL
 */
(function($) {
	$.fn.autogrow = function(options) {
	
	    this.filter('textarea').each(function() {
	
	        var $this       = $(this),
	            minHeight   = $this.height(),
	            lineHeight  = $this.css('lineHeight');
	
	        var shadow = $('<div></div>').css({
	            position:   'absolute',
	            top:        -10000,
	            left:       -10000,
	            width:      $(this).width() - parseInt($this.css('paddingLeft')) - parseInt($this.css('paddingRight')),
	            fontSize:   $this.css('fontSize'),
	            fontFamily: $this.css('fontFamily'),
	            lineHeight: $this.css('lineHeight'),
	            resize:     'none'
	        }).appendTo(document.body);
	
	        var update = function() {
	
	            var times = function(string, number) {
	                for (var i = 0, r = ''; i < number; i ++) r += string;
	                return r;
	            };
	
            var val = this.value.replace(/</g, '&lt;')
                                .replace(/>/g, '&gt;')
                                .replace(/&/g, '&amp;')
                                .replace(/\n$/, '<br/>&nbsp;')
                                .replace(/\n/g, '<br/>')
                                .replace(/ {2,}/g, function(space) { return times('&nbsp;', space.length -1) + ' ' });
	
	            shadow.html(val);
	            $(this).css('height', Math.max(shadow.height() + 20, minHeight));
	
	        }
	
	        $(this).change(update).keyup(update).keydown(update);
	
	        update.apply(this);
	
	    });
	
	    return this;
	
	} 
})(jQuery);

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
/**
 * Loads the desired editor, personally I hate editors, I will just make self sizeing text areas.
 */
var Startup = {
    
    /**
     * Prepares functionality for use in the UI
     * @access private
     */
    _setupUi: function() {
        $('textarea').autogrow();
    },

    /**
     * Builds the UI interactions
     *
     * @access public
     * @return void
     */
    init: function() {        
        this._setupUi();
    }
};
    
// "Instansiates prototypical objects"
$(function(){
	Startup.init();
    HeaderNavigation.init();
});